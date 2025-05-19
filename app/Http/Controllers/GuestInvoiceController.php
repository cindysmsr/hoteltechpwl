<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class GuestInvoiceController extends Controller
{
    public function show($id)
    {
        $invoice = Invoice::with(['reservation.guest', 'reservation.rooms.roomType'])
            ->where('id', $id)
            ->whereHas('reservation.guest', function($query) {
                $query->where('email', Auth::user()->email);
            })
            ->firstOrFail();

        return view('guest.invoices.show', compact('invoice'));
    }

    public function download($id)
    {
        $invoice = Invoice::with(['reservation.guest', 'reservation.rooms.roomType'])
            ->where('id', $id)
            ->whereHas('reservation.guest', function($query) {
                $query->where('email', Auth::user()->email);
            })
            ->firstOrFail();

        $numNights = \Carbon\Carbon::parse($invoice->reservation->check_in_date)
            ->diffInDays(\Carbon\Carbon::parse($invoice->reservation->check_out_date));

        $pdf = PDF::loadView('guest.invoices.pdf', [
            'invoice' => $invoice,
            'numNights' => $numNights
        ]);

        $filename = 'invoice_' . $invoice->invoice_number . '.pdf';

        return $pdf->download($filename);
    }
}
