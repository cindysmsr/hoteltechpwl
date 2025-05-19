@extends('layouts.admin')
@section('title', 'Edit Tipe Kamar')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center mb-6">
        <a href="{{ route('room-types.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded mr-2">
            &larr; Kembali
        </a>
        <h1 class="text-2xl font-bold">Edit Tipe Kamar</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <form action="{{ route('room-types.update', $roomType->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Tipe Kamar</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $roomType->name) }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2"
                            required>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga per Malam</label>
                        <div class="relative mt-1">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="price" id="price" value="{{ old('price', $roomType->price) }}" 
                                class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2"
                                required>
                        </div>
                        @error('price')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="capacity" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas</label>
                        <input type="number" name="capacity" id="capacity" value="{{ old('capacity', $roomType->capacity) }}" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2"
                            required>
                        @error('capacity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" id="description" rows="4" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2"
                            required>{{ old('description', $roomType->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="img" class="block text-sm font-medium text-gray-700 mb-1">Gambar Kamar</label>
                        @if($roomType->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $roomType->image) }}" alt="{{ $roomType->name }}" class="h-48 w-auto object-cover rounded-md">
                                <p class="text-sm text-gray-500 mt-1">Gambar saat ini</p>
                            </div>
                        @endif
                        <input type="file" name="img" id="img" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 px-4 py-2"
                            accept="image/*">
                        <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar. Format yang didukung: JPG, JPEG, PNG, GIF. Ukuran maksimal: 3MB</p>
                        @error('img')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="amenities" class="block text-sm font-medium text-gray-700 mb-1">Fasilitas</label>
                        <div class="mt-1 relative">
                            <div class="flex flex-wrap gap-2 p-2 min-h-24 border rounded-md border-gray-300 shadow-sm focus-within:border-blue-500 focus-within:ring focus-within:ring-blue-500 focus-within:ring-opacity-50">
                                @php
                                    $amenitiesArray = old('amenities', is_array($roomType->amenities) ? $roomType->amenities : json_decode($roomType->amenities, true) ?? []);
                                @endphp
                                
                                <div id="amenities-container" class="flex flex-wrap gap-2 w-full">
                                    @foreach($amenitiesArray as $index => $amenity)
                                    <div class="bg-blue-100 rounded-md px-2 py-1 flex items-center">
                                        <input type="hidden" name="amenities[]" value="{{ $amenity }}">
                                        <span>{{ $amenity }}</span>
                                        <button type="button" class="ml-1 text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">×</button>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <input type="text" id="amenities-input" 
                                    class="flex-grow p-1 outline-none border-none focus:ring-0"
                                    placeholder="Masukkan fasilitas dan tekan Enter (contoh: TV, AC, WiFi)">
                            </div>
                            <p class="text-gray-500 text-xs mt-1">The amenities field must be an array.</p>
                        </div>
                        @error('amenities')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Perbarui Tipe Kamar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('amenities-input');
    const container = document.getElementById('amenities-container');
    
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            
            const value = this.value.trim();
            if (value) {
                // Create a new tag element
                const tag = document.createElement('div');
                tag.className = 'bg-blue-100 rounded-md px-2 py-1 flex items-center';
                tag.innerHTML = `
                    <input type="hidden" name="amenities[]" value="${value}">
                    <span>${value}</span>
                    <button type="button" class="ml-1 text-red-500 hover:text-red-700" onclick="this.parentElement.remove()">×</button>
                `;
                
                container.appendChild(tag);
                this.value = '';
            }
        }
    });
});
</script>
@endsection