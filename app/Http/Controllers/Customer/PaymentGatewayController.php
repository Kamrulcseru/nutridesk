<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentGatewayController extends Controller
{
    protected PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function showGatewayPage(Request $request, Order $order)
    {
        if ($order->user_id !== auth()->id() && auth()->user()->role !== 'super_admin') {
            abort(403);
        }

        $gateway = $request->query('gateway', 'bkash');

        return view('customer.payment_gateway', compact('order', 'gateway'));
    }

    public function processCallback(Request $request, Order $order)
    {
        $gateway = $request->query('gateway', 'bkash');
        $status = $request->input('status', $request->query('status', 'success'));

        if ($status === 'success') {
            $trxId = strtoupper($gateway) . '_' . strtoupper(Str::random(10));
            $this->paymentService->completePayment($order, $trxId);

            return redirect()->route('customer.dashboard')
                ->with('success', 'পেমেন্ট সফলভাবে সম্পন্ন হয়েছে! আপনার সাবস্ক্রিপশন সক্রিয় করা হয়েছে এবং মোবাইলে নিশ্চিতকরণ এসএমএস পাঠানো হয়েছে।');
        } else {
            return redirect()->route('customer.dashboard')
                ->with('error', 'পেমেন্ট সম্পন্ন হয়নি অথবা বাতিল করা হয়েছে। দয়া করে আবার চেষ্টা করুন।');
        }
    }
}
