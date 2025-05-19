<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function show(Invoice $invoice)
    {
        $invoice->load([
            'reservation' => function($query) {
                $query->with([
                    'guest', 
                    'reservationRooms.room.roomType'
                ]);
            }
        ]);

        return view('admin.reservations.invoice', compact('invoice'));
    }

    public function markAsPaid(Request $request, Invoice $invoice)
    {
        $validatedData = $request->validate([
            'payment_method' => 'required|in:cash,transfer,credit_card'
        ]);

        $invoice->update([
            'payment_status' => 'paid',
            'payment_method' => $validatedData['payment_method']
        ]);

        // Optionally update reservation payment status
        $invoice->reservation->update([
            'payment_status' => 'paid'
        ]);

        return redirect()->route('reservations.invoices.show', $invoice)
            ->with('success', 'Faktur berhasil ditandai sebagai lunas.');
    }
}
