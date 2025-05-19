@extends('layouts.admin')

@section('title', 'Detail Faktur')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Detail Faktur</h1>
        <div class="flex space-x-2">
            <a href="{{ route('reservations.show', $invoice->reservation) }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Kembali
            </a>
            @if($invoice->payment_status != 'paid')
                <button onclick="openPaymentModal()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                    Tandai Lunas
                </button>
            @endif
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden mb-6">
        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <h2 class="text-xl font-semibold mb-4">Informasi Faktur</h2>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="text-gray-600">No. Faktur:</div>
                        <div>{{ $invoice->invoice_number }}</div>
                        
                        <div class="text-gray-600">Tanggal:</div>
                        <div>{{ $invoice->created_at->format('d M Y H:i') }}</div>
                        
                        <div class="text-gray-600">Status Pembayaran:</div>
                        <div>
                            @switch($invoice->payment_status)
                                @case('paid')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Lunas
                                    </span>
                                    @break
                                @case('partial')
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Sebagian
                                    </span>
                                    @break
                                @default
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                        Belum Dibayar
                                    </span>
                            @endswitch
                        </div>
                        
                        <div class="text-gray-600">Metode Pembayaran:</div>
                        <div>{{ $invoice->payment_method ?? 'Belum Ditentukan' }}</div>
                    </div>
                </div>
                
                <div>
                    <h2 class="text-xl font-semibold mb-4">Informasi Reservasi</h2>
                    <div class="grid grid-cols-2 gap-2">
                        <div class="text-gray-600">No. Reservasi:</div>
                        <div>{{ $invoice->reservation->reservation_number }}</div>
                        
                        <div class="text-gray-600">Nama Tamu:</div>
                        <div>{{ $invoice->reservation->guest->name }}</div>
                        
                        <div class="text-gray-600">Check In:</div>
                        <div>{{ \Carbon\Carbon::parse($invoice->reservation->check_in_date)->format('d M Y') }}</div>
                        
                        <div class="text-gray-600">Check Out:</div>
                        <div>{{ \Carbon\Carbon::parse($invoice->reservation->check_out_date)->format('d M Y') }}</div>
                    </div>
                </div>
            </div>
            
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-4">Detail Pembayaran</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Deskripsi
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jumlah
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Total Kamar</td>
                                <td class="px-6 py-4 text-right">
                                    Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">Pajak</td>
                                <td class="px-6 py-4 text-right">
                                    Rp {{ number_format($invoice->tax_amount ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr class="font-semibold bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap">Total Keseluruhan</td>
                                <td class="px-6 py-4 text-right">
                                    Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            @if($invoice->notes)
            <div class="mt-6">
                <h2 class="text-xl font-semibold mb-4">Catatan</h2>
                <p class="text-gray-700 bg-gray-50 p-4 rounded">
                    {{ $invoice->notes }}
                </p>
            </div>
            @endif
        </div>
    </div>
</div>

@if($invoice->payment_status != 'paid')
<div id="paymentModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full">
        <h2 class="text-xl font-bold mb-4">Konfirmasi Pembayaran</h2>
        <form action="{{ route('reservations.invoices.mark-paid', $invoice->id) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Metode Pembayaran</label>
                <select name="payment_method" class="w-full border rounded px-3 py-2" required>
                    <option value="">Pilih Metode Pembayaran</option>
                    <option value="cash">Tunai</option>
                    <option value="transfer">Transfer Bank</option>
                    <option value="credit_card">Kartu Kredit</option>
                </select>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closePaymentModal()" class="bg-gray-500 text-white px-4 py-2 rounded">
                    Batal
                </button>
                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">
                    Konfirmasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openPaymentModal() {
    document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
}
</script>
@endif
@endsection