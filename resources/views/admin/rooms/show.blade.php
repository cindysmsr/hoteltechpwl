@extends('layouts.admin')
@section('title', 'Detail Kamar')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('rooms.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
            &larr; Kembali
        </a>
        <h1 class="text-2xl font-bold">Detail Kamar</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Kamar {{ $room->room_number }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Nomor Kamar:</p>
                    <p class="text-gray-800">{{ $room->room_number }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Lantai:</p>
                    <p class="text-gray-800">{{ $room->floor }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Tipe Kamar:</p>
                    <p class="text-gray-800">{{ $room->roomType->name }}</p>
                </div>

                <div>
                    <p class="text-sm text-gray-500 mb-1">Status:</p>
                    <p class="text-gray-800">
                        @if($room->status == 'available')
                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">Tersedia</span>
                        @elseif($room->status == 'occupied')
                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs">Terisi</span>
                        @else
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs">Maintenance</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="border-t border-gray-200 pt-4 mt-4">
                <h3 class="text-lg font-semibold mb-3">Detail Tipe Kamar</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Deskripsi:</p>
                        <p class="text-gray-800">{{ $room->roomType->description }}</p>
                    </div>

                    <div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-1">Harga:</p>
                            <p class="text-gray-800 font-semibold">Rp {{ number_format($room->roomType->price, 0, ',', '.') }} / malam</p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500 mb-1">Kapasitas:</p>
                            <p class="text-gray-800">{{ $room->roomType->capacity }} orang</p>
                        </div>
                    </div>
                </div>

                <div class="mb-6">
                    <p class="text-sm text-gray-500 mb-2">Fasilitas:</p>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $amenitiesArray = old('amenities', is_array($room->roomType->amenities) ? $room->roomType->amenities : json_decode($room->roomType->amenities, true) ?? []);
                        @endphp
                        @foreach(@$amenitiesArray as $amenity)
                            <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $amenity }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    Dibuat: {{ $room->created_at->format('d M Y H:i') }}
                    <br>
                    Terakhir diperbarui: {{ $room->updated_at->format('d M Y H:i') }}
                </div>

                <div class="flex space-x-3">
                    <a href="{{ route('rooms.edit', $room->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Edit
                    </a>
                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus kamar ini?')">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection