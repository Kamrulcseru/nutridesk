<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NutriDesk - Payment Gateway Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Hind+Siliguri:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', 'Hind Siliguri', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-800 flex items-center justify-center min-h-screen p-4">

    @if($gateway === 'bkash')
        <!-- Official bKash Tokenized Gateway UI Simulation -->
        <div class="max-w-md w-full bg-white rounded-3xl overflow-hidden shadow-2xl border border-pink-500/20">
            <!-- bKash Pink Header -->
            <div class="bg-[#E2136E] text-white p-6 text-center relative">
                <div class="w-16 h-16 bg-white text-[#E2136E] rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-md font-black text-2xl tracking-tighter">
                    bKash
                </div>
                <h2 class="text-xl font-bold tracking-tight">Merchant: NutriDesk Fresh Fruit Ltd</h2>
                <p class="text-xs text-pink-100 mt-0.5">Invoice #{{ $order->order_number }}</p>
                <div class="mt-4 bg-pink-700/60 rounded-xl py-2 px-4 inline-block">
                    <span class="text-xs uppercase tracking-wider text-pink-200">Amount to Pay</span>
                    <span class="block text-2xl font-black text-white">৳ {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Payment Simulation Steps -->
            <form action="{{ route('payment.callback', $order->id) }}" method="POST" class="p-6 sm:p-8 space-y-5">
                @csrf
                <input type="hidden" name="gateway" value="bkash">
                <input type="hidden" name="status" value="success">

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Your bKash Account Number</label>
                        <input type="text" value="{{ $order->customer_phone }}" required class="w-full text-sm rounded-xl border-slate-300 p-3 border focus:border-[#E2136E] focus:ring-[#E2136E] font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Verification OTP Code (Sandbox: 123456)</label>
                        <input type="text" value="123456" required class="w-full text-sm rounded-xl border-slate-300 p-3 border font-mono tracking-widest text-center text-lg">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">bKash PIN (Demo: 12345)</label>
                        <input type="password" value="12345" required class="w-full text-sm rounded-xl border-slate-300 p-3 border font-mono text-center tracking-widest text-lg">
                    </div>
                </div>

                <div class="bg-pink-50 p-3 rounded-xl border border-pink-100 text-[11px] text-pink-900 flex items-center gap-2">
                    <i class="fa-solid fa-shield-halved text-[#E2136E] text-base"></i>
                    <span>Secure 256-bit Encrypted Transaction Powered by bKash PGW.</span>
                </div>

                <div class="space-y-2 pt-2">
                    <button type="submit" class="w-full py-3.5 bg-[#E2136E] hover:bg-[#c20f5e] text-white font-bold rounded-xl shadow-lg shadow-pink-600/30 transition text-sm">
                        Confirm & Pay ৳ {{ number_format($order->total_amount, 2) }}
                    </button>
                    <a href="{{ route('customer.dashboard') }}" class="w-full py-2.5 text-center text-xs font-bold text-slate-500 hover:text-slate-700 block">
                        Cancel Payment
                    </a>
                </div>
            </form>
        </div>
    @else
        <!-- SSLCommerz / Card Gateway UI Simulation -->
        <div class="max-w-md w-full bg-white rounded-3xl overflow-hidden shadow-2xl border border-slate-200">
            <div class="bg-slate-900 text-white p-6 text-center">
                <div class="w-12 h-12 bg-emerald-500 text-white rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-md text-xl">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <h2 class="text-lg font-bold">Secure Online Card Checkout</h2>
                <p class="text-xs text-slate-400">NutriDesk Merchant Invoice #{{ $order->order_number }}</p>
                <div class="mt-3">
                    <span class="text-2xl font-black text-emerald-400">৳ {{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <form action="{{ route('payment.callback', $order->id) }}" method="POST" class="p-6 sm:p-8 space-y-4">
                @csrf
                <input type="hidden" name="gateway" value="card">
                <input type="hidden" name="status" value="success">

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Card Holder Name</label>
                    <input type="text" value="{{ $order->customer_name }}" required class="w-full text-xs rounded-xl border-slate-300 p-2.5 border">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Card Number (Visa / MasterCard / AMEX)</label>
                    <input type="text" value="4532 &bull;&bull;&bull;&bull; &bull;&bull;&bull;&bull; 8899" required class="w-full text-xs rounded-xl border-slate-300 p-2.5 border font-mono">
                </div>

                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Expiry Date</label>
                        <input type="text" value="12/28" required class="w-full text-xs rounded-xl border-slate-300 p-2.5 border text-center font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">CVV / CVC</label>
                        <input type="password" value="888" required class="w-full text-xs rounded-xl border-slate-300 p-2.5 border text-center font-mono">
                    </div>
                </div>

                <div class="space-y-2 pt-4">
                    <button type="submit" class="w-full py-3.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl shadow-lg transition text-xs">
                        Authorize Payment & Complete Subscription
                    </button>
                    <a href="{{ route('customer.dashboard') }}" class="w-full py-2 text-center text-xs text-slate-400 hover:text-slate-600 block">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    @endif

</body>
</html>
