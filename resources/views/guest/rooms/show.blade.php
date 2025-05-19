@extends('layouts.guest')

@section('title', 'Detail Tipe Kamar - ' . $roomType->name)

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6 flex items-center">
            <a href="{{ route('home') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>

        <!-- Room Type Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4h8a2 2 0 012 2v12a2 2 0 01-2 2H8a2 2 0 01-2-2V6a2 2 0 012-2z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16" />
                                <circle cx="15" cy="12" r="1" stroke="currentColor" stroke-width="2" fill="none" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">{{ $roomType->name }}</h1>
                            <p class="mt-1">Rp {{ number_format($roomType->price, 0, ',', '.') }} / malam</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Room Type Details -->
            <div class="p-6">
                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Room Image Placeholder -->
                <div class="mb-8">
                    @if ($roomType->img)
                        <img src="{{ asset( 'storage/' . $roomType->img) }}" alt="{{ $roomType->name }}" class="w-full h-full object-cover rounded-lg">
                    @else
                        <img src="https://placehold.co/400x300" alt="{{ $roomType->name }}" class="w-full h-full object-cover">
                    @endif
                </div>

                <!-- Room Description -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Deskripsi Kamar</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <p class="text-gray-700">{{ $roomType->description }}</p>
                    </div>
                </div>

                <!-- Room Details -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Detail Kamar</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-500">Kapasitas</p>
                                <p class="font-medium flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ $roomType->capacity }} Orang
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Harga per Malam</p>
                                <p class="font-medium flex items-center">
                                    Rp {{ number_format($roomType->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Fasilitas</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <ul class="list-disc list-inside text-gray-700">
                            @foreach($roomType->amenities as $amenity)
                                <li>{{ $amenity }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Available Rooms -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Kamar Tersedia</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        @if($roomType->rooms->where('status', 'available')->count() > 0)
                            <p class="text-green-600 font-medium">
                                {{ $roomType->rooms->where('status', 'available')->count() }} kamar tersedia
                            </p>
                            <ul class="mt-2 space-y-2">
                                @foreach($roomType->rooms->where('status', 'available') as $room)
                                    <li class="flex justify-between items-center p-2 bg-white rounded-lg shadow-sm">
                                        <span>Nomor Kamar: {{ $room->room_number }}</span>
                                        <span>Lantai: {{ $room->floor }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-red-600 font-medium">Tidak ada kamar tersedia saat ini.</p>
                        @endif
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row justify-between gap-4">
                    @auth()
                        <a href="{{ route('guest.reservations.create', $roomType->id) }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Pesan Sekarang
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Login untuk Memesan
                        </a>
                    @endauth

                    <a href="{{ route('home') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Kembali ke Pencarian
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection