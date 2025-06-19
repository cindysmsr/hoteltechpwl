<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Reservation;
use App\Models\ReservationRoom;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\Invoice;
use App\Models\Review;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GuestReservationController extends Controller
{
    public function searchRooms(Request $request)
    {
        $validated = $request->validate([
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'room_type' => 'nullable'
        ]);

        $checkInDate = Carbon::parse($validated['check_in_date']);
        $checkOutDate = Carbon::parse($validated['check_out_date']);
        $numNights = $checkInDate->diffInDays($checkOutDate);
        $adults = $validated['adults'];

        $query = RoomType::where('capacity', '>=', $adults);

        $roomTypesOption = RoomType::all();

        if ($request->room_type && $request->room_type != 'Semua Tipe') {
            $query->where('id', $request->room_type);
        }

        $roomTypes = $query->with(['rooms' => function($query) use ($checkInDate, $checkOutDate) {
            $query->where('status', 'available')
                ->whereDoesntHave('reservations', function($query) use ($checkInDate, $checkOutDate) {
                    $query->where(function($q) use ($checkInDate, $checkOutDate) {
                        $q->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                          ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                          ->orWhere(function($q) use ($checkInDate, $checkOutDate) {
                              $q->where('check_in_date', '<=', $checkInDate)
                                ->where('check_out_date', '>=', $checkOutDate);
                          });
                    })->whereIn('status', ['confirmed', 'checked_in']);
                });
        }])->get();

        foreach ($roomTypes as $roomType) {
            $roomType->available_count = $roomType->rooms->count();
        }

        return view('guest.reservation.search-results', compact(
            'roomTypes',
            'checkInDate',
            'checkOutDate',
            'numNights',
            'validated',
            'roomTypesOption'
        ));
    }

    public function createReservation($roomTypeId, Request $request)
    {
        $roomType = RoomType::findOrFail($roomTypeId);

        $checkInDate = $request->check_in_date;
        $checkOutDate = $request->check_out_date;
        $adults = $request->adults;
        $children = $request->children ?? 0;
        $checkInDate = $checkInDate ?? now();
        $checkOutDate = $checkOutDate ?? ($checkInDate ? Carbon::parse($checkInDate)->addDay() : now()->addDay());
        $numNights = Carbon::parse($checkInDate)->diffInDays(Carbon::parse($checkOutDate));

        $totalAmount = $roomType->price * $numNights;

        return view('guest.reservation.create', compact(
            'roomType',
            'checkInDate',
            'checkOutDate',
            'adults',
            'children',
            'numNights',
            'totalAmount'
        ));
    }

    public function storeReservation(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'id_card_type' => 'required|string|max:50',
            'id_card_number' => 'required|string|max:50',
        ]);

        $guest = Auth::user()->guest;

        if (!$guest) {
            $guest = Guest::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'id_card_type' => $validated['id_card_type'],
                'id_card_number' => $validated['id_card_number'],
            ]);

            Auth::user()->update(['guest_id' => $guest->id]);
        }

        $roomType = RoomType::findOrFail($validated['room_type_id']);
        $availableRoom = Room::where('room_type_id', $roomType->id)
            ->where('status', 'available')
            ->whereDoesntHave('reservations', function($query) use ($validated) {
                $query->where(function($q) use ($validated) {
                    $q->whereBetween('check_in_date', [$validated['check_in_date'], $validated['check_out_date']])
                      ->orWhereBetween('check_out_date', [$validated['check_in_date'], $validated['check_out_date']])
                      ->orWhere(function($q) use ($validated) {
                          $q->where('check_in_date', '<=', $validated['check_in_date'])
                            ->where('check_out_date', '>=', $validated['check_out_date']);
                      });
                })->whereIn('status', ['confirmed', 'checked_in']);
            })
            ->first();

        if (!$availableRoom) {
            return back()->with('error', 'Maaf, tidak ada kamar tersedia untuk tanggal yang dipilih.');
        }

        $checkInDate = Carbon::parse($validated['check_in_date']);
        $checkOutDate = Carbon::parse($validated['check_out_date']);
        $numNights = $checkInDate->diffInDays($checkOutDate);
        $totalAmount = $roomType->price * $numNights;

        $reservation = Reservation::create([
            'reservation_number' => 'RES-' . strtoupper(Str::random(8)),
            'guest_id' => $guest->id,
            'check_in_date' => $validated['check_in_date'],
            'check_out_date' => $validated['check_out_date'],
            'adults' => $validated['adults'],
            'children' => $validated['children'] ?? 0,
            'status' => 'confirmed',
            'total_amount' => $totalAmount,
            'payment_status' => 'pending',
        ]);

        ReservationRoom::create([
            'reservation_id' => $reservation->id,
            'room_id' => $availableRoom->id,
            'price_per_night' => $roomType->price,
        ]);

        $availableRoom->status = "occupied";
        $availableRoom->save();

        $taxRate = 0.11;
        $taxAmount = $totalAmount * $taxRate;
        $grandTotal = $totalAmount + $taxAmount;

        $invoice = Invoice::create([
            'invoice_number' => $this->generateInvoiceNumber(),
            'reservation_id' => $reservation->id,
            'total_amount' => $totalAmount,
            'tax_amount' => $taxAmount,
            'grand_total' => $grandTotal,
            'payment_method' => 'pending',
            'payment_status' => 'pending',
            'notes' => 'Reservasi online',
        ]);

        return redirect()->route('guest.reservation.confirmation', ['reservation' => $reservation->id])
            ->with('success', 'Reservasi berhasil dibuat!');
    }

    public function showConfirmation(Reservation $reservation)
    {
        if (Auth::user()->guest->id != $reservation->guest_id) {
            abort(403, 'Unauthorized action.');
        }

        $reservation->load('guest', 'rooms.roomType', 'invoice');
        $checkInDate = Carbon::parse($reservation->check_in_date);
        $checkOutDate = Carbon::parse($reservation->check_out_date);
        $numNights = $checkInDate->diffInDays($checkOutDate);

        return view('guest.reservation.confirmation', compact('reservation', 'numNights'));
    }

    public function showPayment(Reservation $reservation)
    {
        if (Auth::user()->guest->id != $reservation->guest_id) {
            abort(403, 'Unauthorized action.');
        }

        $reservation->load('guest', 'rooms.roomType', 'invoice');

        return view('guest.reservation.payment', compact('reservation'));
    }

    public function processPayment(Request $request, Reservation $reservation)
    {
        if (Auth::user()->guest->id != $reservation->guest_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:credit_card,bank_transfer,e-wallet',
            'card_number' => 'required_if:payment_method,credit_card',
            'card_holder' => 'required_if:payment_method,credit_card',
            'expiry_date' => 'required_if:payment_method,credit_card',
            'cvv' => 'required_if:payment_method,credit_card',
            'bank_name' => 'required_if:payment_method,bank_transfer',
            'account_number' => 'required_if:payment_method,bank_transfer',
            'wallet_provider' => 'required_if:payment_method,e-wallet',
            'wallet_number' => 'required_if:payment_method,e-wallet',
        ]);

        $reservation->invoice->update([
            'payment_method' => $validated['payment_method'],
            'payment_status' => 'paid',
        ]);

        $reservation->update([
            'payment_status' => 'paid'
        ]);

        return redirect()->route('guest.reservations.success', $reservation->id);
    }

    public function showSuccessPage(Reservation $reservation)
    {
        if (Auth::user()->guest->id != $reservation->guest_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('guest.reservation.payment_success', [
            'reservation' => $reservation
        ]);
    }

    public function listReservations(Request $request)
    {
        $guest = Auth::user()->guest;

        if (!$guest) {
            return redirect()->route('guest.profile.create')
                ->with('warning', 'Harap lengkapi profil tamu terlebih dahulu.');
        }

        $query = Reservation::where('guest_id', $guest->id)
            ->with('rooms.roomType', 'invoice')
            ->orderBy('created_at', 'desc');

        if ($request->has('search') && $request->search) {
            $query->where('reservation_number', 'like', '%' . $request->reservation_number . '%');
        }

        $reservations = $query->paginate(10);

        return view('guest.reservation.list', compact('reservations'));
    }

    public function showReservation(Reservation $reservation)
    {
        if (Auth::user()->guest->id != $reservation->guest_id) {
            abort(403, 'Unauthorized action.');
        }

        $reservation->load('guest', 'rooms.roomType', 'invoice');
        $checkInDate = Carbon::parse($reservation->check_in_date);
        $checkOutDate = Carbon::parse($reservation->check_out_date);
        $numNights = $checkInDate->diffInDays($checkOutDate);

        return view('guest.reservation.show', compact('reservation', 'numNights'));
    }

    public function cancelReservation(Reservation $reservation)
    {
        if (Auth::user()->guest->id != $reservation->guest_id) {
            abort(403, 'Unauthorized action.');
        }

        if ($reservation->status != 'confirmed') {
            return back()->with('error', 'Hanya reservasi dengan status terkonfirmasi yang dapat dibatalkan.');
        }

        $reservation->update([
            'status' => 'cancelled'
        ]);

        $reservation->rooms()->update([
            'status' => 'available'
        ]);

        $previousUrl = url()->previous();
        $listReservationsUrl = route('guest.reservations.list');

        if ($previousUrl === $listReservationsUrl) {
            return redirect()->route('guest.reservations.list')
                ->with('success', 'Reservasi berhasil dibatalkan.');
        }

        return redirect()->route('home')
            ->with('success', 'Reservasi berhasil dibatalkan.');
    }

    public function createReview(Reservation $reservation)
    {
        if (Auth::user()->guest->id != $reservation->guest_id) {
            abort(403, 'Unauthorized action.');
        }

        $reservation = Reservation::where('id', $reservation->id)
            ->where('guest_id', Auth::user()->guest->id)
            ->where('status', 'checked_out')
            ->firstOrFail();

        $existingReview = Review::where('reservation_id', $reservation->id)->first();
        if ($existingReview) {
            return redirect()->route('guest.reservations.list')
                ->with('error', 'Anda sudah memberikan ulasan untuk reservasi ini.');
        }

        return view('guest.reviews.create', compact('reservation'));
    }

    public function storeReview(Request $request, $reservationId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'staff_rating' => 'nullable|integer|min:1|max:5',
            'cleanliness_rating' => 'nullable|integer|min:1|max:5',
            'comfort_rating' => 'nullable|integer|min:1|max:5',
            'would_recommend' => 'nullable|boolean'
        ]);

        $reservation = Reservation::where('id', $reservationId)
            ->where('guest_id', Auth::user()->guest->id)
            ->where('status', 'checked_out')
            ->firstOrFail();

        $existingReview = Review::where('reservation_id', $reservationId)->first();
        if ($existingReview) {
            return redirect()->route('guest.reservations.list')
                ->with('error', 'Anda sudah memberikan ulasan untuk reservasi ini.');
        }

        Review::create([
            'reservation_id' => $reservation->id,
            'guest_id' => Auth::user()->guest->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'staff_rating' => $request->staff_rating,
            'cleanliness_rating' => $request->cleanliness_rating,
            'comfort_rating' => $request->comfort_rating,
            'would_recommend' => $request->would_recommend
        ]);

        return redirect()->route('guest.reservations.list')
            ->with('success', 'Terima kasih atas ulasan Anda!');
    }

    private function generateInvoiceNumber()
    {
        $prefix = 'INV-' . date('Ym');
        $latestInvoice = Invoice::where('invoice_number', 'like', $prefix . '%')
            ->latest()
            ->first();

        $number = $latestInvoice
            ? intval(substr($latestInvoice->invoice_number, -4)) + 1
            : 1;

        return $prefix . sprintf('%04d', $number);
    }
}
