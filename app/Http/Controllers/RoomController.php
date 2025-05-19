<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class RoomController extends Controller
{
    public function index(Request $request): View
    {
        $query = Room::with('roomType');

        // Apply filters
        if ($request->has('room_type') && $request->room_type) {
            $query->where('room_type_id', $request->room_type);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('floor') && $request->floor) {
            $query->where('floor', $request->floor);
        }

        if ($request->has('search') && $request->search) {
            $query->where('room_number', 'like', '%' . $request->search . '%');
        }

        $rooms = $query->paginate(10);

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

        return view('admin.rooms.index', compact('rooms', 'roomTypes', 'floors', 'availableRoomsByType', 'roomStats'));
    }
    public function search(Request $request): View
    {
        $query = $request->input('query');
        $rooms = Room::with('roomType')
            ->where('room_number', 'like', '%' . $query . '%')
            ->orWhereHas('roomType', function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%');
            })
            ->get();

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create(): View
    {
        $roomTypes = RoomType::all();
        return view('admin.rooms.create', compact('roomTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms',
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|integer',
            'status' => 'required|in:available,occupied,maintenance'
        ]);

        Room::create($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Kamar berhasil ditambahkan.');
    }

    public function show(Room $room): View
    {
        $room = Room::with('roomType')->findOrFail($room->id);
        return view('admin.rooms.show', compact('room'));
    }

    public function edit(Room $room): View
    {
        $roomTypes = RoomType::all();
        return view('admin.rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, Room $room): RedirectResponse
    {
        $validated = $request->validate([
            'room_number' => 'required|string|max:10|unique:rooms,room_number,' . $room->id,
            'room_type_id' => 'required|exists:room_types,id',
            'floor' => 'required|integer',
            'status' => 'required|in:available,occupied,maintenance'
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Kamar berhasil diperbarui.');
    }

    public function destroy(Room $room): RedirectResponse
    {
        // Check if room is occupied before deletion
        if ($room->status === 'occupied') {
            return redirect()->route('rooms.index')
                ->with('error', 'Tidak dapat menghapus kamar yang sedang ditempati.');
        }

        $room->delete();

        return redirect()->route('rooms.index')
            ->with('success', 'Kamar berhasil dihapus.');
    }

    public function guestShow(RoomType $roomType)
    {
        $roomType->load('rooms');
        return view('guest.rooms.show', compact('roomType'));
    }
}
