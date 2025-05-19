<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Invoice;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $rooms = Room::with('roomType')->get();

        $roomTypes = RoomType::all();
        $floors = Room::select('floor')->distinct()->pluck('floor');
        $availableRoomsByType = Room::where('status', 'available')
            ->selectRaw('room_type_id, COUNT(*) as count')
            ->groupBy('room_type_id')
            ->pluck('count', 'room_type_id');

        $roomStats = [
            'available' => Room::where('status', 'available')->count(),
            'occupied' => Room::where('status', 'occupied')->count(),
            'maintenance' => Room::where('status', 'maintenance')->count(),
        ];
        
        $totalReservations = Reservation::count();
        $activeReservations = Reservation::where('status', 'confirmed')->count();
        $checkedInReservations = Reservation::where('status', 'checked_in')->count();
        
        $monthlyRevenue = Invoice::whereMonth('created_at', Carbon::now()->month)
            ->sum('grand_total');
        
        $annualRevenue = Invoice::whereYear('created_at', Carbon::now()->year)
            ->sum('grand_total');
        
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $availableRooms = $totalRooms - $occupiedRooms;
        
        $topGuests = Guest::withCount('reservations')
            ->orderBy('reservations_count', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('rooms', 'roomTypes', 'floors', 'availableRoomsByType', 'roomStats', 'totalReservations', 'activeReservations', 'checkedInReservations', 'monthlyRevenue', 'annualRevenue', 'totalRooms', 'occupiedRooms', 'availableRooms', 'topGuests'));
    }
}
