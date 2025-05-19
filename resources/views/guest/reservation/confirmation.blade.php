@extends('layouts.guest')

@section('title', 'Konfirmasi Reservasi')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <!-- Success Message -->
        @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Confirmation Card -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Confirmation Header -->
            <div class="bg-blue-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold">Reservasi Berhasil</h1>
                        <p class="mt-1">Nomor Reservasi: {{ $reservation->reservation_number }}</p>
                    </div>
                    <div class="bg-white text-blue-600 rounded-full p-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <!-- Reservation Details -->
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4">Detail Reservasi</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-700">
                        <div>
                            <p class="mb-2"><span class="font-medium">Check-in:</span> {{ \Carbon\Carbon::parse($reservation->check_in_date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                            <p class="mb-2"><span class="font-medium">Check-out:</span> {{ \Carbon\Carbon::parse($reservation->check_out_date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                            <p class="mb-2"><span class="font-medium">Durasi:</span> {{ $numNights }} malam</p>
                            <p class="mb-2"><span class="font-medium">Jumlah Tamu:</span> {{ $reservation->adults }} dewasa{{ $reservation->children > 0 ? ', ' . $reservation->children . ' anak' : '' }}</p>
                        </div>
                        <div>
                            <p class="mb-2"><span class="font-medium">Status:</span> <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $reservation->status == 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($reservation->status) }}</span></p>
                            <p class="mb-2"><span class="font-medium">Tanggal Pemesanan:</span> {{ $reservation->created_at->locale('id')->isoFormat('D MMMM YYYY, HH:mm') }}</p>
                            <p class="mb-2"><span class="font-medium">Status Pembayaran:</span> <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $reservation->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">{{ ucfirst($reservation->payment_status) }}</span></p>
                        </div>
                    </div>
                </div>
                
                <div class="mb-6 border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-semibold mb-4">Informasi Kamar</h2>
                    @foreach ($reservation->rooms as $room)
                    <div class="flex flex-col md:flex-row md:items-start mb-4 pb-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                        <div class="flex-shrink-0 bg-gray-200 w-full md:w-32 h-24 rounded flex items-center justify-center md:mr-4 mb-4 md:mb-0">
                            @if ($room->roomType->img)
                                <img src="{{ asset('storage/' . $room->roomType->img) }}" class="w-full h-full object-cover rounded-md"/>
                            @else
                                <svg class="w-12 h-12 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 22H2V2h2v20zm18 0h-2V2h2v20zM17 7H7v10h10V7z"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="flex-grow">
                            <h3 class="font-semibold text-lg">{{ $room->roomType->name }}</h3>
                            <p class="text-gray-600 mb-2">Kamar {{ $room->room_number }}, Lantai {{ $room->floor }}</p>
                            <div class="grid grid-cols-2 gap-2 mt-3">
                                <div class="flex items-center text-sm text-gray-600">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Kapasitas: {{ $room->roomType->capacity }} orang
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="font-semibold">Rp</span>
                                    <span class="ml-1">{{ number_format($room->roomType->price, 0, ',', '.') }} / malam</span>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mb-6 border-t border-gray-200 pt-6">
                    <h2 class="text-lg font-semibold mb-4">Detail Pembayaran</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between mb-2">
                            <span>Subtotal</span>
                            <span>Rp {{ number_format($reservation->total_amount - ($reservation->total_amount * 0.11), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Pajak (11%)</span>
                            <span>Rp {{ number_format($reservation->total_amount * 0.11, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg border-t border-gray-300 pt-2 mt-2">
                            <span>Total</span>
                            <span>Rp {{ number_format($reservation->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-4 md:mb-0">
                            <h2 class="text-lg font-semibold">Butuh bantuan?</h2>
                            <p class="text-gray-600">Hubungi kami di <a href="tel:+62123456789" class="text-blue-600 hover:underline">+62 123 456 789</a></p>
                        </div>
                        <div class="flex space-x-3">
                            @if($reservation->payment_status != 'paid')
                            <a href="{{ route('guest.reservations.payment', $reservation->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition">
                                Bayar Sekarang
                            </a>
                            @endif
                            <a href="{{ route('guest.reservations.invoice', $reservation->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition">
                                Download Invoice
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection