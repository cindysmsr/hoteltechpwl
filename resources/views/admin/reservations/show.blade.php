@extends('layouts.admin')
@section('title', 'Detail Reservasi')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Detail Reservasi</h1>
        <div class="flex space-x-2">
            <a href="{{ route('reservations.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Kembali
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-6">
            <div class="flex flex-wrap mb-6">
                <div class="w-full md:w-1/2 mb-4 md:mb-0">
                    <h2 class="text-xl font-semibold mb-4">Informasi Reservasi</h2>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="text-gray-600">No. Reservasi:</div>
                        <div>{{ $reservation->reservation_number }}</div>
                        
                        <div class="text-gray-600">Status:</div>
                        <div>
                            @if($reservation->status == 'confirmed')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Dikonfirmasi
                                </span>
                            @elseif($reservation->status == 'checked_in')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Check In
                                </span>
                            @elseif($reservation->status == 'checked_out')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Check Out
                                </span>
                            @elseif($reservation->status == 'cancelled')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Dibatalkan
                                </span>
                            @endif
                        </div>
                        
                        <div class="text-gray-600">Check In:</div>
                        <div>{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('d M Y') }}</div>
                        
                        <div class="text-gray-600">Check Out:</div>
                        <div>{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('d M Y') }}</div>
                        
                        <div class="text-gray-600">Durasi:</div>
                        <div>{{ \Carbon\Carbon::parse($reservation->check_in_date)->diffInDays(\Carbon\Carbon::parse($reservation->check_out_date)) }} malam</div>
                        
                        <div class="text-gray-600">Jumlah Tamu:</div>
                        <div>{{ $reservation->adults }} dewasa, {{ $reservation->children }} anak</div>
                        
                        <div class="text-gray-600">Dibuat pada:</div>
                        <div>{{ $reservation->created_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
                
                <div class="w-full md:w-1/2">
                    <h2 class="text-xl font-semibold mb-4">Informasi Tamu</h2>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="text-gray-600">Nama:</div>
                        <div>{{ $reservation->guest->name }}</div>
                        
                        <div class="text-gray-600">Email:</div>
                        <div>{{ $reservation->guest->email }}</div>
                        
                        <div class="text-gray-600">Telepon:</div>
                        <div>{{ $reservation->guest->phone }}</div>
                        
                        <div class="text-gray-600">Alamat:</div>
                        <div>{{ $reservation->guest->address }}</div>
                        
                        <div class="text-gray-600">Tipe Identitas:</div>
                        <div>{{ $reservation->guest->id_card_type }}</div>
                        
                        <div class="text-gray-600">No. Identitas:</div>
                        <div>{{ $reservation->guest->id_card_number }}</div>
                    </div>
                </div>
            </div>
            
            <h2 class="text-xl font-semibold mb-4">Kamar Dipesan</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                No. Kamar
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipe Kamar
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Lantai
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga per Malam
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Subtotal
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reservation->reservationRooms as $reservationRoom)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $reservationRoom->room->room_number }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $reservationRoom->room->roomType->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $reservationRoom->room->floor }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                Rp {{ number_format($reservationRoom->price_per_night, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                Rp {{ number_format($reservationRoom->price_per_night * \Carbon\Carbon::parse($reservation->check_in_date)->diffInDays(\Carbon\Carbon::parse($reservation->check_out_date)), 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-4">Informasi Pembayaran</h2>
                <div class="grid grid-cols-2 gap-2 max-w-lg">
                    <div class="text-gray-600">Total Tagihan:</div>
                    <div class="font-semibold">Rp {{ number_format($reservation->total_amount, 0, ',', '.') }}</div>
                    
                    <div class="text-gray-600">Status Pembayaran:</div>
                    <div>
                        @if($reservation->payment_status == 'paid')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Lunas
                            </span>
                        @elseif($reservation->payment_status == 'partial')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Sebagian
                            </span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Belum Dibayar
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-4">Faktur Terkait</h2>
            @if($reservation->invoice->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No. Faktur
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $reservation->invoice->invoice_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $reservation->invoice->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    Rp {{ number_format($reservation->invoice->grand_total, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($reservation->invoice->payment_status == 'paid')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Lunas
                                        </span>
                                    @elseif($reservation->invoice->payment_status == 'partial')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Sebagian
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Belum Dibayar
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('reservations.invoices.show', $reservation->invoice->id) }}" class="text-blue-600 hover:text-blue-900">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">Belum ada faktur yang dibuat untuk reservasi ini.</p>
                <div class="mt-4">
                    <a href="{{ route('invoices.create', ['reservation_id' => $reservation->id]) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Buat Faktur
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection