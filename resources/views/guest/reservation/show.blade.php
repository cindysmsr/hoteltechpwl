@extends('layouts.guest')

@section('title', 'Detail Reservasi')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center">
            <a href="{{ route('guest.reservations.list') }}" class="flex items-center text-blue-600 hover:text-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Daftar Reservasi
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Reservation Header -->
            <div class="bg-blue-600 p-6 text-white">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold">Detail Reservasi</h1>
                            <p class="mt-1">{{ $reservation->reservation_number }}</p>
                        </div>
                    </div>
                    <div>
                        @if($reservation->status == 'confirmed')
                            <span class="px-3 py-1 inline-flex items-center bg-blue-700 rounded-full text-white text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Dikonfirmasi
                            </span>
                        @elseif($reservation->status == 'checked_in')
                            <span class="px-3 py-1 inline-flex items-center bg-green-700 rounded-full text-white text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Check-in
                            </span>
                        @elseif($reservation->status == 'checked_out')
                            <span class="px-3 py-1 inline-flex items-center bg-purple-700 rounded-full text-white text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Check-out
                            </span>
                        @elseif($reservation->status == 'cancelled')
                            <span class="px-3 py-1 inline-flex items-center bg-red-700 rounded-full text-white text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Dibatalkan
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex items-center bg-gray-700 rounded-full text-white text-sm font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Pending
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Reservation Details -->
            <div class="p-6">
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

                <!-- Stay Details -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Detail Menginap</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500">Tanggal Check-in</p>
                                    <p class="font-medium flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('d M Y') }}
                                        <span class="text-sm text-gray-500 ml-2">(14:00)</span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Jumlah Tamu</p>
                                    <p class="font-medium flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                        {{ $reservation->adults }} Dewasa, {{ $reservation->children }} Anak
                                    </p>
                                </div>
                            </div>
                            <div>
                                <div class="mb-4">
                                    <p class="text-sm text-gray-500">Tanggal Check-out</p>
                                    <p class="font-medium flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('d M Y') }}
                                        <span class="text-sm text-gray-500 ml-2">(12:00)</span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Durasi Menginap</p>
                                    <p class="font-medium flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ \Carbon\Carbon::parse($reservation->check_in_date)->diffInDays($reservation->check_out_date) }} Malam
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Room Details -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Detail Kamar</h2>
                    <div class="space-y-4">
                        @foreach($reservation->rooms as $room)
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="mb-4 md:mb-0">
                                    <h3 class="font-medium text-lg">{{ $room->roomType->name }}</h3>
                                    <p class="text-gray-600">Nomor Kamar: {{ $room->room_number }}</p>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Fasilitas:</p>
                                        @foreach ($room->roomType->amenities as $amenties)
                                            <p class="text-sm">{{ $amenties }}</p>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm text-gray-500">Harga per malam</p>
                                    <p class="font-medium text-lg">Rp {{ number_format($room->roomType->price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Details -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Detail Pembayaran</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        @if($reservation->invoice)
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <p class="text-sm text-gray-500">Nomor Invoice</p>
                                <p class="font-medium">{{ $reservation->invoice->invoice_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status Pembayaran</p>
                                @if($reservation->invoice->payment_status == 'paid')
                                    <p class="font-medium text-green-600">Lunas</p>
                                @elseif($reservation->invoice->payment_status == 'pending')
                                    <p class="font-medium text-yellow-600">Menunggu Pembayaran</p>
                                @else
                                    <p class="font-medium text-red-600">Belum Dibayar</p>
                                @endif
                            </div>
                        </div>

                        @if($reservation->invoice->payment_method)
                        <div class="mb-4 border-b border-gray-200 pb-4">
                            <p class="text-sm text-gray-500 mb-2">Metode Pembayaran</p>
                            <div class="flex items-center">
                                @if($reservation->invoice->payment_method == 'credit_card')
                                    <div class="mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Kartu Kredit</p>
                                        @php
                                            $session = session('payment_data', []);
                                            $maskedCardNumber = isset($session['card_number']) ?
                                                '**** **** **** ' . substr($session['card_number'], -4) :
                                                'xxxx xxxx xxxx xxxx';
                                        @endphp
                                        <p class="text-sm text-gray-500">{{ $maskedCardNumber }}</p>
                                    </div>
                                @elseif($reservation->invoice->payment_method == 'bank_transfer')
                                    <div class="mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">Transfer Bank</p>
                                        @php
                                            $session = session('payment_data', []);
                                            $bankName = $session['bank_name'] ?? '';
                                        @endphp
                                        <p class="text-sm text-gray-500">{{ $bankName }}</p>
                                    </div>
                                @elseif($reservation->invoice->payment_method == 'e-wallet')
                                    <div class="mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium">E-Wallet</p>
                                        @php
                                            $session = session('payment_data', []);
                                            $walletProvider = $session['wallet_provider'] ?? '';
                                        @endphp
                                        <p class="text-sm text-gray-500">{{ $walletProvider }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Payment Summary -->
                        <div>
                            <div class="flex justify-between mb-2">
                                <span>Total Biaya Kamar</span>
                                <span>Rp {{ number_format($reservation->total_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between mb-2">
                                <span>Pajak (11%)</span>
                                <span>Rp {{ number_format($reservation->total_amount * 0.11, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between font-bold text-lg border-t border-gray-300 pt-2 mt-2">
                                <span>Total Pembayaran</span>
                                <span>Rp {{ number_format($reservation->total_amount + ($reservation->total_amount * 0.11), 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @else
                        <div class="text-center py-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="mt-2 text-gray-600">Invoice belum dibuat untuk reservasi ini.</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Guest Details -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Detail Tamu</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Nama Tamu</p>
                                <p class="font-medium">{{ $reservation->guest->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="font-medium">{{ $reservation->guest->email }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nomor Telepon</p>
                                <p class="font-medium">{{ $reservation->guest->phone }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Alamat</p>
                                <p class="font-medium">{{ $reservation->guest->address }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jenis Identitas</p>
                                <p class="font-medium">{{ $reservation->guest->id_card_type }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nomor Identitas</p>
                                <p class="font-medium">{{ $reservation->guest->id_card_number }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex flex-col sm:flex-row justify-between gap-4">
                    @if($reservation->invoice && $reservation->invoice->payment_status == 'paid')
                        <a href="{{ route('guest.invoices.download', $reservation->invoice->id) }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Unduh Invoice
                        </a>
                    @elseif($reservation->invoice && $reservation->invoice->payment_status == 'pending')
                        <a href="{{ route('guest.reservations.payment', $reservation->invoice->id) }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            </svg>
                            Lanjutkan Pembayaran
                        </a>
                    @endif

                    @if($reservation->status == 'confirmed' && !$reservation->invoice)
                        <form action="{{ route('guest.reservations.cancel', $reservation->id) }}" method="POST" class="inline-flex">
                            @csrf
                            @method('PATCH')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin membatalkan reservasi ini?')" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                Batalkan Reservasi
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('guest.reservations.list') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
            </div>
        </div>
    </div>
</div>
@endsection
