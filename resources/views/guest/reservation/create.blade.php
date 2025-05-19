@extends('layouts.guest')

@section('title', 'Buat Reservasi')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Reservation Form -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="md:flex">
                <!-- Left Column - Room Details -->
                <div class="md:w-1/3 bg-gray-50 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Detail Kamar</h2>
                    
                    <div class="bg-gray-300 h-40 flex items-center justify-center mb-4 rounded">
                        @if ($roomType->img)
                            <img src="{{ asset( 'storage/' . $roomType->img) }}" class="w-full h-40 object-cover rounded-lg" />
                        @else
                            <svg class="w-18 h-18 text-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 22H2V2h2v20zm18 0h-2V2h2v20zM17 7H7v10h10V7z"></path>
                            </svg>
                        @endif
                    </div>
                    
                    <h3 class="text-lg font-bold">{{ $roomType->name }}</h3>
                    <p class="text-blue-600 font-bold my-2">Rp {{ number_format($roomType->price, 0, ',', '.') }} / malam</p>
                    
                    <div class="border-t border-gray-200 my-4 pt-4">
                        <h4 class="font-medium mb-2">Fasilitas Kamar:</h4>
                        <ul class="space-y-1">
                            @foreach ($roomType->amenities as $amenity)
                                <li class="flex items-start">
                                    <svg class="w-5 h-5 mr-1.5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    {{ trim($amenity) }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                    <div class="border-t border-gray-200 my-4 pt-4">
                        <h4 class="font-medium mb-2">Ringkasan Menginap:</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>Check-in:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($checkInDate)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Check-out:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($checkOutDate)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Durasi:</span>
                                <span class="font-medium">{{ $numNights }} malam</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Tamu:</span>
                                <span class="font-medium">{{ $adults }} dewasa{{ $children > 0 ? ', ' . $children . ' anak' : '' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 my-4 pt-4">
                        <h4 class="font-medium mb-2">Rincian Biaya:</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span>{{ $roomType->name }} x {{ $numNights }} malam:</span>
                                <span class="font-medium">Rp {{ number_format($roomType->price * $numNights, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Pajak (11%):</span>
                                <span class="font-medium">Rp {{ number_format($totalAmount * 0.11, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between font-bold text-blue-600 text-base border-t border-gray-200 pt-2 mt-2">
                                <span>Total:</span>
                                <span>Rp {{ number_format($totalAmount * 1.11, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Reservation Form -->
                <div class="md:w-2/3 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Informasi Pemesan</h2>
                    
                    <form action="{{ route('guest.reservations.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="room_type_id" value="{{ $roomType->id }}">
                        <input type="hidden" name="check_in_date" value="{{ $checkInDate }}">
                        <input type="hidden" name="check_out_date" value="{{ $checkOutDate }}">
                        <input type="hidden" name="adults" value="{{ $adults }}">
                        <input type="hidden" name="children" value="{{ $children }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @php
                                $user = auth()->user();
                                $guest = $user->guest ?? null;
                            @endphp
                            
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $guest ? $guest->name : $user->name) }}" required class="p-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('name')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $guest ? $guest->email : $user->email) }}" required class="p-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('email')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="space-y-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $guest ? $guest->phone : '') }}" required class="p-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('phone')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="space-y-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">Alamat</label>
                                <input type="text" id="address" name="address" value="{{ old('address', $guest ? $guest->address : '') }}" required class="p-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('address')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="space-y-2">
                                <label for="id_card_type" class="block text-sm font-medium text-gray-700">Jenis Identitas</label>
                                <select id="id_card_type" name="id_card_type" required class="p-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                    <option value="">Pilih Jenis Identitas</option>
                                    <option value="KTP" {{ old('id_card_type', $guest ? $guest->id_card_type : '') == 'KTP' ? 'selected' : '' }}>KTP</option>
                                    <option value="SIM" {{ old('id_card_type', $guest ? $guest->id_card_type : '') == 'SIM' ? 'selected' : '' }}>SIM</option>
                                    <option value="Passport" {{ old('id_card_type', $guest ? $guest->id_card_type : '') == 'Passport' ? 'selected' : '' }}>Passport</option>
                                </select>
                                @error('id_card_type')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="space-y-2">
                                <label for="id_card_number" class="block text-sm font-medium text-gray-700">Nomor Identitas</label>
                                <input type="text" id="id_card_number" name="id_card_number" value="{{ old('id_card_number', $guest ? $guest->id_card_number : '') }}" required class="p-3 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('id_card_number')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mt-8 border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium mb-4">Ketentuan dan Kebijakan</h3>
                            
                            <div class="space-y-4 text-sm text-gray-600 mb-6">
                                <p>• Check-in: 14.00 WIB, Check-out: 12.00 WIB</p>
                                <p>• Pembayaran harus diselesaikan segera setelah pemesanan</p>
                                <p>• Pembatalan kurang dari 24 jam sebelum check-in dikenakan biaya 1 malam</p>
                                <p>• Deposit Rp 500.000 diperlukan saat check-in (dapat dikembalikan saat check-out)</p>
                            </div>
                            
                            <div class="flex items-center mb-6">
                                <input type="checkbox" id="terms" name="terms" required class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="terms" class="ml-2 block text-sm text-gray-700">
                                    Saya menyetujui semua syarat dan ketentuan yang berlaku
                                </label>
                            </div>
                            
                            <div class="flex justify-between items-center">
                                <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    Kembali
                                </a>
                                
                                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Konfirmasi Reservasi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection