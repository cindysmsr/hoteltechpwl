@extends('layouts.admin')
@section('title', 'Edit Kamar')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('rooms.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
            &larr; Kembali
        </a>
        <h1 class="text-2xl font-bold">Edit Kamar</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <form action="{{ route('rooms.update', $room->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="room_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Kamar</label>
                        <input type="text" name="room_number" id="room_number" value="{{ old('room_number', $room->room_number) }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2"
                            required>
                        @error('room_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="floor" class="block text-sm font-medium text-gray-700 mb-1">Lantai</label>
                        <input type="number" name="floor" id="floor" value="{{ old('floor', $room->floor) }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2"
                            required>
                        @error('floor')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="room_type_id" class="block text-sm font-medium text-gray-700 mb-1">Tipe Kamar</label>
                        <select name="room_type_id" id="room_type_id" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2"
                            required>
                            <option value="">Pilih Tipe Kamar</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type->id }}" {{ (old('room_type_id', $room->room_type_id) == $type->id) ? 'selected' : '' }}>
                                    {{ $type->name }} - Rp {{ number_format($type->price, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                        @error('room_type_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2"
                            required>
                            <option value="available" {{ (old('status', $room->status) == 'available') ? 'selected' : '' }}>Tersedia</option>
                            <option value="occupied" {{ (old('status', $room->status) == 'occupied') ? 'selected' : '' }}>Terisi</option>
                            <option value="maintenance" {{ (old('status', $room->status) == 'maintenance') ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Perbarui Kamar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection