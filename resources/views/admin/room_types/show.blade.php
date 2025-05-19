@extends('layouts.admin')
@section('title', 'Detail Tipe Kamar')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('room-types.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
            &larr; Kembali
        </a>
        <h1 class="text-2xl font-bold">Detail Tipe Kamar</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">{{ $roomType->name }}</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Deskripsi:</p>
                    <p class="text-gray-800">{{ $roomType->description }}</p>
                </div>

                <div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-500 mb-1">Harga:</p>
                        <p class="text-gray-800 font-semibold">Rp {{ number_format($roomType->price, 0, ',', '.') }} / malam</p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 mb-1">Kapasitas:</p>
                        <p class="text-gray-800">{{ $roomType->capacity }} orang</p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <p class="text-sm text-gray-500 mb-2">Fasilitas:</p>
                <div class="flex flex-wrap gap-2">
                    @php
                    $amenitiesArray = old('amenities', is_array($roomType->amenities) ? $roomType->amenities : json_decode($roomType->amenities, true) ?? []);
                    @endphp
                    @foreach ($amenitiesArray as $amenity)
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $amenity }}</span>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                <div class="text-sm text-gray-500">
                    Dibuat: {{ $roomType->created_at->format('d M Y H:i') }}
                    <br>
                    Terakhir diperbarui: {{ $roomType->updated_at->format('d M Y H:i') }}
                </div>

                <div class="flex space-x-3">
                    <a href="{{ route('room-types.edit', $roomType->id) }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                        Edit
                    </a>
                    <form action="{{ route('room-types.destroy', $roomType->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus tipe kamar ini?')">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
