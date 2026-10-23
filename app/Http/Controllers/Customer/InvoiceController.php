<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function viewInvoice(Order $order)
    {
        if ($order->user_id !== auth()->id() && !in_array(auth()->user()->role, ['super_admin', 'staff'])) {
            abort(403);
        }

        $order->load(['user', 'package', 'subscription']);

        return view('customer.invoice', compact('order'));
    }

    public function downloadPdf(Order $order)
    {
        if ($order->user_id !== auth()->id() && !in_array(auth()->user()->role, ['super_admin', 'staff'])) {
            abort(403);
        }

        $order->load(['user', 'package', 'subscription']);

        $pdf = Pdf::loadView('customer.invoice_pdf', compact('order'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download("NutriDesk-Invoice-{$order->order_number}.pdf");
    }
}
