<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\ReservationRoom;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::with(['guest'])
            ->when(request('search'), function ($query) {
                $query->where('reservation_number', 'like', '%' . request('search') . '%');
            })
            ->when(request('status'), function ($query) {
                $query->where('status', request('status'));
            })
            ->when(request('date_from'), function ($query) {
                $query->whereDate('check_in_date', '>=', request('date_from'));
            })
            ->when(request('date_to'), function ($query) {
                $query->whereDate('check_out_date', '<=', request('date_to'));
            })
            ->paginate(10);

        return view('admin.reservations.index', compact('reservations'));
    }
    
    public function create()
    {
        $guests = Guest::all();
        $rooms = Room::where('status', 'available')->get();
        return view('admin.reservations.create', compact('guests', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'room_ids' => 'required|array',
            'room_ids.*' => 'exists:rooms,id',
        ]);

        DB::beginTransaction();
        try {
            // Generate reservation number
            $reservationNumber = 'RES-' . date('Ymd') . '-' . rand(1000, 9999);
            
            // Calculate total amount
            $totalAmount = 0;
            $roomIds = $request->room_ids;
            $checkInDate = new \DateTime($request->check_in_date);
            $checkOutDate = new \DateTime($request->check_out_date);
            $nights = $checkInDate->diff($checkOutDate)->days;
            
            foreach ($roomIds as $roomId) {
                $room = Room::findOrFail($roomId);
                $roomType = $room->roomType;
                $totalAmount += $roomType->price * $nights;
            }
            
            // Create reservation
            $reservation = Reservation::create([
                'reservation_number' => $reservationNumber,
                'guest_id' => $request->guest_id,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'adults' => $request->adults,
                'children' => $request->children ?? 0,
                'status' => 'pending',
                'total_amount' => $totalAmount,
                'payment_status' => 'unpaid',
            ]);
            
            // Attach rooms to reservation
            foreach ($roomIds as $roomId) {
                $room = Room::findOrFail($roomId);
                $reservation->rooms()->attach($roomId, [
                    'price_per_night' => $room->roomType->price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Update room status
                $room->update(['status' => 'booked']);

                ReservationRoom::create([
                    'reservation_id' => $reservation->id,
                    'room_id' => $roomId,
                    'price_per_night' => $roomType->price,
                ]);
            }
            
            DB::commit();
            
            return redirect()->route('reservations.index')
                ->with('success', 'Reservasi berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Reservation $reservation)
    {
        $reservation->load(['guest', 'reservationRooms', 'invoice']);
        return view('admin.reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $guests = Guest::all();
        $currentRoomIds = $reservation->reservationRooms->pluck('room_id')->toArray();
        $availableRooms = Room::where('status', 'available')
            ->orWhereIn('id', $currentRoomIds)
            ->get();
        $roomTypes = RoomType::all();
            
        return view('admin.reservations.edit', compact('reservation', 'guests', 'availableRooms', 'roomTypes'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'room_ids' => 'required|array',
            'room_ids.*' => 'exists:rooms,id',
        ]);

        DB::beginTransaction();
        try {
            // Get current room IDs
            $currentRoomIds = $reservation->reservationRooms->pluck('room_id')->toArray();
            $newRoomIds = $request->room_ids;
            
            // Calculate total amount
            $totalAmount = 0;
            $checkInDate = new \DateTime($request->check_in_date);
            $checkOutDate = new \DateTime($request->check_out_date);
            $nights = $checkInDate->diff($checkOutDate)->days;
            
            foreach ($newRoomIds as $roomId) {
                $room = Room::findOrFail($roomId);
                $roomType = $room->roomType;
                $totalAmount += $roomType->price * $nights;
            }
            
            // Update reservation
            $reservation->update([
                'guest_id' => $request->guest_id,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
                'adults' => $request->adults,
                'children' => $request->children ?? 0,
                'total_amount' => $totalAmount,
            ]);
            
            // Detach rooms that are no longer needed
            $roomsToDetach = array_diff($currentRoomIds, $newRoomIds);
            foreach ($roomsToDetach as $roomId) {
                $room = Room::findOrFail($roomId);
                $room->update(['status' => 'available']);
            }
            
            // Detach all rooms first
            $reservation->rooms()->detach();
            
            // Attach new rooms
            foreach ($newRoomIds as $roomId) {
                $room = Room::findOrFail($roomId);
                $reservation->rooms()->attach($roomId, [
                    'price_per_night' => $room->roomType->price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                // Update room status
                if (!in_array($roomId, $currentRoomIds)) {
                    $room->update(['status' => 'booked']);
                }
            }
            
            DB::commit();
            
            return redirect()->route('reservations.index')
                ->with('success', 'Reservasi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy(Reservation $reservation)
    {
        DB::beginTransaction();
        try {
            // Free up the rooms
            foreach ($reservation->reservationRooms as $reservationRoom) {
                $room = $reservationRoom->room;
                if ($room) {
                    $room->update(['status' => 'available']);
                }
            }
            
            // Delete the reservation
            $reservation->delete();
            
            DB::commit();
            
            return redirect()->route('reservations.index')
                ->with('success', 'Reservasi berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function confirm(Reservation $reservation)
    {
        try {
            $reservation->update(['status' => 'confirmed']);
            
            // You may want to send a confirmation email to the guest here
            
            return redirect()->route('reservations.index')
                ->with('success', 'Reservasi berhasil dikonfirmasi.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function cancel(Reservation $reservation)
    {
        DB::beginTransaction();
        try {
            // Update reservation status
            $reservation->update(['status' => 'cancelled']);
            
            // Free up the rooms
            foreach ($reservation->reservationRooms as $reservationRoom) {
                $room = $reservationRoom->room;
                if ($room) {
                    $room->update(['status' => 'available']);
                }
            }
            
            DB::commit();
            
            // You may want to send a cancellation email to the guest here
            
            return redirect()->route('reservations.index')
                ->with('success', 'Reservasi berhasil dibatalkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function checkIn(Reservation $reservation)
    {
        try {
            if ($reservation->status !== 'confirmed') {
                return back()->with('error', 'Reservasi harus dikonfirmasi sebelum check-in.');
            }

            $reservation->update(['status' => 'checked_in']);

            return redirect()->route('reservations.index')
                ->with('success', 'Check-in berhasil.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function checkOut(Reservation $reservation)
    {
        DB::beginTransaction();
        try {
            if ($reservation->status !== 'checked_in') {
                return back()->with('error', 'Reservasi harus dalam status check-in sebelum check-out.');
            }

            // Free up the rooms
            foreach ($reservation->reservationRooms as $reservationRoom) {
                $room = $reservationRoom->room;
                if ($room) {
                    $room->update(['status' => 'available']);
                }
            }

            $reservation->update(['status' => 'checked_out']);

            DB::commit();

            return redirect()->route('reservations.index')
                ->with('success', 'Check-out berhasil.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}