@extends('layouts.admin')
@section('title', 'Tambah Tipe Kamar')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('room-types.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
            &larr; Kembali
        </a>
        <h1 class="text-2xl font-bold">Tambah Tipe Kamar Baru</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <form action="{{ route('room-types.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Tipe Kamar</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500">Rp</span>
                        </div>
                        <input type="number" name="price" id="price" value="{{ old('price') }}"
                               class="w-full pl-12 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                               required min="0" step="0.01">
                    </div>
                    @error('price')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas (orang)</label>
                    <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           required min="1">
                    @error('capacity')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-4">
                <label for="img" class="block text-sm font-medium text-gray-700 mb-1">Gambar Kamar</label>
                <input type="file" name="img" id="img" 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       accept="image/*">
                <p class="text-xs text-gray-500 mt-1">Format yang didukung: JPG, JPEG, PNG, GIF. Ukuran maksimal: 3MB</p>
                @error('img')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="amenities" class="block text-sm font-medium text-gray-700 mb-1">Fasilitas</label>
                <div class="bg-gray-50 p-4 rounded-md">
                    <p class="text-sm text-gray-500 mb-2">Pilih fasilitas yang tersedia:</p>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                        @foreach(['WiFi', 'TV', 'AC', 'Minibar', 'Sarapan', 'Bathtub', 'Shower', 'Pemandangan Kota', 'Safe Deposit Box', 'Coffee Maker'] as $amenity)
                        <div class="flex items-center">
                            <input type="checkbox" name="amenities[]" value="{{ $amenity }}" id="amenity-{{ $loop->index }}"
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                   {{ in_array($amenity, old('amenities', [])) ? 'checked' : '' }}>
                            <label for="amenity-{{ $loop->index }}" class="ml-2 text-sm text-gray-700">{{ $amenity }}</label>
                        </div>
                        @endforeach
                    </div>
                </div>
                @error('amenities')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Simpan Tipe Kamar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection