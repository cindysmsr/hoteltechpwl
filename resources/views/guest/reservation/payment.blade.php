@extends('layouts.guest')

@section('title', 'Pembayaran Reservasi')

@section('content')
<div class="py-12 bg-gray-100">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
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
        
        @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded" role="alert">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="font-medium">{{ session('error') }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Payment Header -->
            <div class="bg-blue-600 p-6 text-white">
                <h1 class="text-2xl font-bold">Pembayaran Reservasi</h1>
                <p class="mt-1">Nomor Reservasi: {{ $reservation->reservation_number }}</p>
            </div>
            
            <!-- Payment Summary -->
            <div class="p-6">
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
                
                <!-- Payment Form -->
                <form method="POST" action="{{ route('guest.reservations.processPayment', $reservation->id) }}">
                    @csrf
                    <div class="mb-6 border-t border-gray-200 pt-6">
                        <h2 class="text-lg font-semibold mb-4">Metode Pembayaran</h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="border rounded-lg p-4 cursor-pointer hover:bg-blue-50 transition duration-200" onclick="selectPaymentMethod('credit_card')">
                                <div class="flex items-center">
                                    <input id="credit_card" type="radio" name="payment_method" value="credit_card" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <label for="credit_card" class="ml-3 flex items-center cursor-pointer">
                                        <span class="text-lg font-medium text-gray-900">Kartu Kredit</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="border rounded-lg p-4 cursor-pointer hover:bg-blue-50 transition duration-200" onclick="selectPaymentMethod('bank_transfer')">
                                <div class="flex items-center">
                                    <input id="bank_transfer" type="radio" name="payment_method" value="bank_transfer" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <label for="bank_transfer" class="ml-3 flex items-center cursor-pointer">
                                        <span class="text-lg font-medium text-gray-900">Transfer Bank</span>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="border rounded-lg p-4 cursor-pointer hover:bg-blue-50 transition duration-200" onclick="selectPaymentMethod('e-wallet')">
                                <div class="flex items-center">
                                    <input id="e-wallet" type="radio" name="payment_method" value="e-wallet" class="h-4 w-4 text-blue-600 focus:ring-blue-500">
                                    <label for="e-wallet" class="ml-3 flex items-center cursor-pointer">
                                        <span class="text-lg font-medium text-gray-900">E-Wallet</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Credit Card Form (hidden by default) -->
                        <div id="credit_card_form" class="hidden space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="card_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Kartu</label>
                                    <input type="text" name="card_number" id="card_number" placeholder="XXXX XXXX XXXX XXXX" class="w-full p-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('card_number')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="card_holder" class="block text-sm font-medium text-gray-700 mb-1">Nama Pemegang Kartu</label>
                                    <input type="text" name="card_holder" id="card_holder" class="w-full p-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('card_holder')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="col-span-1 md:col-span-2">
                                    <label for="expiry_date" class="block text-sm font-medium text-gray-700 mb-1">Masa Berlaku</label>
                                    <input type="text" name="expiry_date" id="expiry_date" placeholder="MM/YY" class="w-full p-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('expiry_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <label for="cvv" class="block text-sm font-medium text-gray-700 mb-1">CVV</label>
                                    <input type="text" name="cvv" id="cvv" placeholder="XXX" class="w-full p-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('cvv')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Bank Transfer Form (hidden by default) -->
                        <div id="bank_transfer_form" class="hidden space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="bank_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Bank</label>
                                    <select name="bank_name" id="bank_name" class="w-full p-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Pilih Bank</option>
                                        <option value="BCA">BCA</option>
                                        <option value="BNI">BNI</option>
                                        <option value="BRI">BRI</option>
                                        <option value="Mandiri">Mandiri</option>
                                    </select>
                                    @error('bank_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="account_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Rekening</label>
                                    <input type="text" name="account_number" id="account_number" class="w-full p-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('account_number')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- E-Wallet Form (hidden by default) -->
                        <div id="e-wallet_form" class="hidden space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="wallet_provider" class="block text-sm font-medium text-gray-700 mb-1">Provider E-Wallet</label>
                                    <select name="wallet_provider" id="wallet_provider" class="w-full p-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Pilih Provider</option>
                                        <option value="GoPay">GoPay</option>
                                        <option value="OVO">OVO</option>
                                        <option value="DANA">DANA</option>
                                        <option value="LinkAja">LinkAja</option>
                                    </select>
                                    @error('wallet_provider')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="wallet_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor E-Wallet</label>
                                    <input type="text" name="wallet_number" id="wallet_number" class="w-full p-3 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                    @error('wallet_number')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-6">
                        <div class="mt-6 flex justify-between">
                            <a href="{{ route('guest.reservations.show', $reservation->id) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Kembali
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function selectPaymentMethod(method) {
        // Hide all payment forms
        document.getElementById('credit_card_form').classList.add('hidden');
        document.getElementById('bank_transfer_form').classList.add('hidden');
        document.getElementById('e-wallet_form').classList.add('hidden');
        
        // Show selected payment form
        document.getElementById(method + '_form').classList.remove('hidden');
        
        // Check the radio button
        document.getElementById(method).checked = true;
    }
</script>
@endsection