@extends('layouts.guest')

@section('title', 'Pembayaran Berhasil')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Success Header -->
            <div class="bg-green-600 p-6 text-white">
                <div class="flex items-center">
                    <div class="mr-4">
                        <svg class="h-12 w-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Pembayaran Berhasil!</h1>
                        <p class="mt-1">Terima kasih atas reservasi Anda</p>
                    </div>
                </div>
            </div>
            
            <!-- Payment Details -->
            <div class="p-6">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4">Detail Reservasi</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Nomor Reservasi</p>
                                <p class="font-medium">{{ $reservation->reservation_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Nomor Invoice</p>
                                <p class="font-medium">{{ $reservation->invoice->invoice_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal Check-in</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Tanggal Check-out</p>
                                <p class="font-medium">{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Jumlah Tamu</p>
                                <p class="font-medium">{{ $reservation->adults }} Dewasa, {{ $reservation->children }} Anak</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status Pembayaran</p>
                                <p class="font-medium text-green-600">Lunas</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4">Metode Pembayaran</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
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
                </div>

                <!-- Payment Summary -->
                <div class="mb-6">
                    <h2 class="text-lg font-semibold mb-4">Ringkasan Pembayaran</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between mb-2">
                            <span>Total Biaya Kamar</span>
                            <span>Rp {{ number_format($reservation->total_amount - ($reservation->total_amount * 0.11), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Pajak (11%)</span>
                            <span>Rp {{ number_format($reservation->total_amount * 0.11, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg border-t border-gray-300 pt-2 mt-2">
                            <span>Total Pembayaran</span>
                            <span>Rp {{ number_format($reservation->total_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Timestamp -->
                <div class="mb-6">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-500">Tanggal & Waktu Pembayaran</span>
                            <span class="text-sm">{{ now()->format('d M Y, H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row justify-between gap-4">
                    <a href="{{ route('guest.invoices.download', $reservation->invoice->id) }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Unduh Invoice
                    </a>
                    <a href="{{ route('guest.reservations.list') }}" class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        Lihat Semua Reservasi
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection