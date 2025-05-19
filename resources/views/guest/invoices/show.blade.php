@extends('layouts.guest')

@section('title', 'Invoice Reservasi')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Invoice Header -->
            <div class="bg-gray-800 p-6 text-white">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">INVOICE</h1>
                        <p class="mt-1">{{ $invoice->invoice_number }}</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <h2 class="text-xl font-bold">HOTELTECH</h2>
                        <p class="text-sm">Jl. Jendral Sudirman No. 123, Jakarta</p>
                        <p class="text-sm">Pusat, 10220, Indonesia</p>
                    </div>
                </div>
            </div>
            
            <!-- Invoice Details -->
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <h3 class="font-medium text-gray-700 mb-2">Invoice Untuk:</h3>
                        <p class="font-bold">{{ $invoice->reservation->guest->name }}</p>
                        <p>{{ $invoice->reservation->guest->email }}</p>
                        <p>{{ $invoice->reservation->guest->phone }}</p>
                        <p>{{ $invoice->reservation->guest->address }}</p>
                    </div>
                    <div class="text-right">
                        <div class="mb-2">
                            <span class="font-medium text-gray-700">Tanggal Invoice:</span>
                            <span class="ml-2">{{ $invoice->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                        </div>
                        <div class="mb-2">
                            <span class="font-medium text-gray-700">Status:</span>
                            <span class="ml-2 inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $invoice->payment_status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($invoice->payment_status) }}
                            </span>
                        </div>
                        <div class="mb-2">
                            <span class="font-medium text-gray-700">Nomor Reservasi:</span>
                            <span class="ml-2">{{ $invoice->reservation->reservation_number }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 pt-6 mb-6">
                    <h3 class="font-semibold text-lg mb-4">Detail Reservasi</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 border-b text-left font-semibold text-sm text-gray-700">Deskripsi</th>
                                    <th class="py-3 px-4 border-b text-center font-semibold text-sm text-gray-700">Durasi</th>
                                    <th class="py-3 px-4 border-b text-center font-semibold text-sm text-gray-700">Harga/Malam</th>
                                    <th class="py-3 px-4 border-b text-right font-semibold text-sm text-gray-700">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $numNights = \Carbon\Carbon::parse($invoice->reservation->check_in_date)->diffInDays(\Carbon\Carbon::parse($invoice->reservation->check_out_date));
                                @endphp
                                
                                @foreach($invoice->reservation->rooms as $room)
                                <tr>
                                    <td class="py-3 px-4 border-b">
                                        <div class="font-medium">{{ $room->roomType->name }} (Kamar {{ $room->room_number }})</div>
                                        <div class="text-sm text-gray-600">Check-in: {{ \Carbon\Carbon::parse($invoice->reservation->check_in_date)->locale('id')->isoFormat('D MMM YYYY') }}</div>
                                        <div class="text-sm text-gray-600">Check-out: {{ \Carbon\Carbon::parse($invoice->reservation->check_out_date)->locale('id')->isoFormat('D MMM YYYY') }}</div>
                                    </td>
                                    <td class="py-3 px-4 border-b text-center">
                                        {{ $numNights }} malam
                                    </td>
                                    <td class="py-3 px-4 border-b text-center">
                                        Rp {{ number_format($room->roomType->price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 border-b text-right">
                                        Rp {{ number_format($room->roomType->price * $numNights, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mb-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="flex justify-between mb-2">
                            <span class="font-medium">Subtotal</span>
                            <span>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="font-medium">Pajak (11%)</span>
                            <span>Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg border-t border-gray-300 pt-2 mt-2">
                            <span>Total</span>
                            <span>Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                
                @if($invoice->notes)
                <div class="mb-6 border-t border-gray-200 pt-4">
                    <h3 class="font-semibold mb-2">Catatan:</h3>
                    <p class="text-gray-700">{{ $invoice->notes }}</p>
                </div>
                @endif
                
                <div class="border-t border-gray-200 pt-6">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
                        <div class="mb-4 md:mb-0">
                            <h3 class="font-semibold">Metode Pembayaran</h3>
                            <p class="text-gray-700 capitalize">{{ $invoice->payment_method ?? 'Belum dibayar' }}</p>
                        </div>
                        <div class="flex space-x-3">
                            @if($invoice->payment_status != 'paid')
                            <a href="{{ route('guest.reservations.payment', $invoice->reservation->id) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition">
                                Bayar Sekarang
                            </a>
                            @endif
                            <a href="{{ route('guest.invoices.download', $invoice->reservation->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition">
                                Cetak Invoice
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-50 p-6 text-center text-sm text-gray-600 border-t border-gray-200">
                <p>Terima kasih telah memilih HOTELTECH. Kami senang dapat melayani Anda.</p>
                <p class="mt-1">Untuk pertanyaan, silakan hubungi kami di <a href="mailto:info@hoteltech.com" class="text-blue-600 hover:underline">info@hoteltech.com</a> atau <a href="tel:+62123456789" class="text-blue-600 hover:underline">+62 123 456 789</a></p>
            </div>
        </div>
    </div>
</div>
@endsection