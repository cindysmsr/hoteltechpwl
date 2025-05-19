<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'DejaVu Sans', Arial, sans-serif;
        }
        body {
            /* width: 100%;
            max-width: 210mm; */
            margin: 0 auto;
            padding: 10mm;
            font-size: 10pt;
            line-height: 1.5;
            color: #333;
        }
        .invoice-container {
            border: 1px solid #e0e0e0;
            padding: 10mm;
        }
        .header-left {
            float: left;
        }
        .header-left h1 {
            color: #2c3e50;
            font-size: 16pt;
            margin-bottom: 3mm;
        }
        .header-right {
            float: right;
            text-align: right;
        }
        .customer-info {
            padding-top: 12mm;
            border-top: 2px solid #2c3e50;
            display: inline-block;
            margin-bottom: 10mm;
            width: 100%;
        }
        .customer-details {
            float: left;
        }
        .customer-details, .invoice-details {
            /* width: auto; */
        }
        .invoice-details {
            text-align: right;
            float: right;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10mm;
        }
        .invoice-table th, .invoice-table td {
            border: 1px solid #ddd;
            padding: 3mm;
            text-align: left;
        }
        .invoice-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .totals {
            margin-left: auto;
            width: 50%;
        }
        .totals-row {
            padding: 2mm 0;
            border-bottom: 1px solid #ddd;
        }
        .totals-row.total {
            text-align: left;
            font-weight: bold;
            font-size: 12pt;
        }
        .footer {
            margin-top: 10mm;
            text-align: center;
            font-size: 8pt;
            color: #666;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="header-left">
                <h1>INVOICE</h1>
                <p>Nomor Invoice: {{ $invoice->invoice_number }}</p>
            </div>
            <div class="header-right">
                <h2>HOTELTECH</h2>
                <p>Jl. Jendral Sudirman No. 123</p>
                <p>Jakarta Pusat, 10220</p>
                <p>Indonesia</p>
            </div>
        </div>

        <div style="clear: both;" />
        <br>

        <!-- Customer and Invoice Details -->
        <div class="customer-info">
            <div class="customer-details">
                <h3>Tagihan Untuk:</h3>
                <p><strong>{{ $invoice->reservation->guest->name }}</strong></p>
                <p>{{ $invoice->reservation->guest->email }}</p>
                <p>{{ $invoice->reservation->guest->phone }}</p>
                <p>{{ $invoice->reservation->guest->address }}</p>
            </div>
            <div class="invoice-details">
                <p><strong>Tanggal Invoice:</strong> {{ $invoice->created_at->locale('id')->isoFormat('D MMMM YYYY') }}</p>
                <p><strong>Status:</strong> {{ ucfirst($invoice->payment_status) }}</p>
                <p><strong>Nomor Reservasi:</strong> {{ $invoice->reservation->reservation_number }}</p>
            </div>
        </div>

        <div style="clear: both;" />
        <br>
        <br>

        <!-- Room Details -->
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Durasi</th>
                    <th>Harga/Malam</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $numNights = \Carbon\Carbon::parse($invoice->reservation->check_in_date)
                        ->diffInDays(\Carbon\Carbon::parse($invoice->reservation->check_out_date));
                @endphp
                @foreach($invoice->reservation->rooms as $room)
                <tr>
                    <td>
                        {{ $room->roomType->name }} (Kamar {{ $room->room_number }})
                        <br>
                        Check-in: {{ \Carbon\Carbon::parse($invoice->reservation->check_in_date)->locale('id')->isoFormat('D MMM YYYY') }}
                        <br>
                        Check-out: {{ \Carbon\Carbon::parse($invoice->reservation->check_out_date)->locale('id')->isoFormat('D MMM YYYY') }}
                    </td>
                    <td>{{ $numNights }} malam</td>
                    <td>Rp {{ number_format($room->roomType->price, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($room->roomType->price * $numNights, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Totals -->
        <div class="totals">
            <div class="totals-row">
                <span>Subtotal</span>
                <span>Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="totals-row">
                <span>Pajak (11%)</span>
                <span>Rp {{ number_format($invoice->tax_amount, 0, ',', '.') }}</span>
            </div>
            <div class="totals-row total">
                <span>Total</span>
                <span>Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Notes -->
        @if($invoice->notes)
        <div class="notes" style="margin-top: 10mm; border-top: 1px solid #ddd; padding-top: 5mm;">
            <h3>Catatan:</h3>
            <p>{{ $invoice->notes }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>Terima kasih telah memilih HOTELTECH</p>
            <p>Untuk pertanyaan, hubungi: info@hoteltech.com | +62 123 456 789</p>
        </div>
    </div>
</body>
</html>