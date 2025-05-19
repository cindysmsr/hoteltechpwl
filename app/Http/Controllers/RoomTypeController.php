<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class RoomTypeController extends Controller
{
    public function index(): View
    {
        $roomTypes = RoomType::paginate(10);
        return view('admin.room_types.index', compact('roomTypes'));
    }

    public function create(): View
    {
        return view('admin.room_types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'amenities' => 'required|array',
            'amenities.*' => 'string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3048'
        ]);

        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->store('room-types', 'public');
            $validated['img'] = $imagePath;
        }

        RoomType::create($validated);

        return redirect()->route('room-types.index')
            ->with('success', 'Tipe kamar berhasil ditambahkan.');
    }

    public function show(RoomType $roomType): View
    {
        return view('admin.room_types.show', compact('roomType'));
    }

    public function edit(RoomType $roomType): View
    {
        return view('admin.room_types.edit', compact('roomType'));
    }

    public function update(Request $request, RoomType $roomType): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'amenities' => 'required|array',
            'amenities.*' => 'string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3048'
        ]);

        if ($request->hasFile('img')) {
            if ($roomType->image && Storage::disk('public')->exists($roomType->image)) {
                Storage::disk('public')->delete($roomType->image);
            }
            
            $imagePath = $request->file('img')->store('room-types', 'public');
            $validated['img'] = $imagePath;
        }
        
        $roomType->update($validated);

        return redirect()->route('room-types.index')
            ->with('success', 'Tipe kamar berhasil diperbarui.');
    }

    public function destroy(RoomType $roomType): RedirectResponse
    {
        if ($roomType->rooms()->count() > 0) {
            return redirect()->route('room-types.index')
                ->with('error', 'Tidak dapat menghapus tipe kamar karena sedang digunakan oleh beberapa kamar.');
        }

        if ($roomType->image && Storage::disk('public')->exists($roomType->image)) {
            Storage::disk('public')->delete($roomType->image);
        }

        $roomType->delete();

        return redirect()->route('room-types.index')
            ->with('success', 'Tipe kamar berhasil dihapus.');
    }
}
