@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

<div class="container mx-auto px-4 py-6">
    <div class="mt-8">
        <h2 class="text-xl font-bold mb-4">Status Kamar</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white shadow-md rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                    <h3 class="font-bold">Tersedia</h3>
                </div>
                <p class="text-2xl font-bold mt-2">{{ $roomStats['available'] ?? 0 }}</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                    <h3 class="font-bold">Ditempati</h3>
                </div>
                <p class="text-2xl font-bold mt-2">{{ $roomStats['occupied'] ?? 0 }}</p>
            </div>
            <div class="bg-white shadow-md rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-yellow-500 rounded-full mr-2"></div>
                    <h3 class="font-bold">Maintenance</h3>
                </div>
                <p class="text-2xl font-bold mt-2">{{ $roomStats['maintenance'] ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Reservasi</h2>
            <div class="space-y-2">
                <p>Total Reservasi: <span class="font-bold">{{ $totalReservations }}</span></p>
                <p>Reservasi Aktif: <span class="font-bold text-blue-600">{{ $activeReservations }}</span></p>
                <p>Checked-In: <span class="font-bold text-green-600">{{ $checkedInReservations }}</span></p>
            </div>
        </div>
        
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Revenue</h2>
            <div class="space-y-2">
                <p>Pendapatan Bulanan: <span class="font-bold text-green-700">Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</span></p>
                <p>Pendapatan Tahunan: <span class="font-bold text-green-900">Rp {{ number_format($annualRevenue, 0, ',', '.') }}</span></p>
            </div>
        </div>
        
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Keterisian Kamar</h2>
            <div class="space-y-2">
                <p>Jumlah Kamar: <span class="font-bold">{{ $totalRooms }}</span></p>
                <p>Kamar yang Dihuni: <span class="font-bold text-red-600">{{ $occupiedRooms }}</span></p>
                <p>Kamar yang Tersedia: <span class="font-bold text-green-600">{{ $availableRooms }}</span></p>
            </div>
        </div>
    </div>

    <div class="mt-8 bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Top Guests</h2>
        <table class="w-full">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2 text-left">Nama</th>
                    <th class="p-2 text-left">Total Reservasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topGuests as $guest)
                <tr class="border-b">
                    <td class="p-2">{{ $guest->name }}</td>
                    <td class="p-2">{{ $guest->reservations_count }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- hallo -->
</div>

@endsection