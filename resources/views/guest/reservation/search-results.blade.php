@extends('layouts.guest')

@section('title', 'Hasil Pencarian Kamar')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Search Results Header -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Hasil Pencarian Kamar</h1>
                    <p class="text-gray-600 mt-1">
                        {{ \Carbon\Carbon::parse($checkInDate)->locale('id')->isoFormat('D MMMM YYYY') }} - 
                        {{ \Carbon\Carbon::parse($checkOutDate)->locale('id')->isoFormat('D MMMM YYYY') }} 
                        ({{ $numNights }} malam)
                    </p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Ubah Pencarian
                    </a>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-lg font-semibold mb-3">Filter</h2>
            <form action="{{ route('guest.reservations.search') }}" method="GET">
                @csrf
                <input type="hidden" name="check_in_date" value="{{ $checkInDate }}">
                <input type="hidden" name="check_out_date" value="{{ $checkOutDate }}">
                <input type="hidden" name="adults" value="{{ $validated['adults'] }}">
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="room_type" class="block text-sm font-medium text-gray-700">Tipe Kamar</label>
                        <select id="room_type" name="room_type" class="mt-1 p-3 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            <option value="Semua Tipe">Semua Tipe</option>
                            @foreach ($roomTypesOption as $type)
                                <option value="{{ $type->id }}" {{ (isset($validated['room_type']) && $validated['room_type'] == $type->id) ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="md:col-span-2 self-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Terapkan Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Room Types Results -->
        <div class="space-y-6">
            @forelse ($roomTypes as $roomType)
                @if ($roomType->available_count > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="md:flex">
                        <div class="md:flex-shrink-0 bg-gray-300 md:w-72 h-48 md:h-auto flex items-center justify-center">
                            @if ($roomType->img)
                                <img src="{{ asset( 'storage/' . $roomType->img) }}" class="w-full h-full object-cover rounded-tl-md" />
                            @else
                                <svg class="w-24 h-24 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 22H2V2h2v20zm18 0h-2V2h2v20zM17 7H7v10h10V7z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="p-6 md:flex-1">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start">
                                <div>
                                    <h2 class="text-2xl font-bold text-gray-800">{{ $roomType->name }}</h2>
                                    <p class="mt-2 text-gray-600">{{ Str::limit($roomType->description, 150) }}</p>
                                    
                                    <div class="mt-4 grid grid-cols-2 gap-2">
                                        @foreach ($roomType->amenities as $amenities)
                                            <div class="flex items-center text-sm text-gray-500">
                                                <svg class="w-4 h-4 mr-1 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                {{ $amenities }}
                                            </div>
                                        @endforeach
                                    </div>
                                    
                                    <p class="mt-4 text-sm text-gray-600">Kapasitas: Maksimal {{ $roomType->capacity }} orang</p>
                                </div>
                                
                                <div class="mt-6 md:mt-0 text-right">
                                    <p class="text-3xl font-bold text-blue-600">Rp {{ number_format($roomType->price, 0, ',', '.') }}</p>
                                    <p class="text-gray-500 text-sm">per malam</p>
                                    
                                    <p class="mt-2 font-medium">
                                        Total: Rp {{ number_format($roomType->price * $numNights, 0, ',', '.') }}
                                        <span class="text-sm text-gray-500">({{ $numNights }} malam)</span>
                                    </p>
                                    
                                    <div class="mt-4">
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-medium text-green-600">{{ $roomType->available_count }}</span> kamar tersedia
                                        </p>
                                        <form action="{{ route('guest.reservations.create', $roomType->id) }}" method="GET">
                                            <input type="hidden" name="check_in_date" value="{{ $checkInDate }}">
                                            <input type="hidden" name="check_out_date" value="{{ $checkOutDate }}">
                                            <input type="hidden" name="adults" value="{{ $validated['adults'] }}">
                                            <input type="hidden" name="children" value="{{ $validated['children'] ?? 0 }}">
                                            
                                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                Pesan Sekarang
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            @empty
                <div class="bg-white rounded-lg shadow-md p-8 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Tidak Ada Kamar Tersedia</h3>
                    <p class="text-gray-500 mb-6">Maaf, tidak ada kamar yang tersedia untuk tanggal yang Anda pilih. Silakan coba tanggal lain atau hubungi kami untuk bantuan.</p>
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Ubah Pencarian
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection