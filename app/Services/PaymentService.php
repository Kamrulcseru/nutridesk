<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Subscription;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentService
{
    protected SmsService $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Process checkout based on chosen payment method
     */
    public function initiatePayment(Order $order): array
    {
        $method = $order->payment_method;

        if ($method === 'bkash') {
            return $this->initiateBkash($order);
        } elseif ($method === 'card' || $method === 'nagad') {
            return $this->initiateSSLCommerz($order);
        } else {
            // Corporate Invoice or Cash on Delivery
            $this->completePayment($order, 'COD_' . Str::random(8));
            return [
                'status' => 'success',
                'redirect_url' => route('customer.dashboard'),
                'message' => 'Order placed successfully under Corporate Invoice / Post-paid.'
            ];
        }
    }

    /**
     * Initiate bKash Payment
     */
    protected function initiateBkash(Order $order): array
    {
        $mode = config('services.bkash.mode', 'sandbox');

        // Check if real bKash merchant credentials exist in .env
        $appKey = config('services.bkash.app_key');
        $appSecret = config('services.bkash.app_secret');

        if ($mode === 'live' && $appKey && $appSecret) {
            try {
                // bKash Live API Call
                $baseUrl = config('services.bkash.base_url', 'https://tokenized.pay.bka.sh/v1.2.0-beta');
                $tokenResponse = Http::withHeaders([
                    'username' => config('services.bkash.username'),
                    'password' => config('services.bkash.password'),
                ])->post("{$baseUrl}/tokenized/checkout/token/grant", [
                    'app_key' => $appKey,
                    'app_secret' => $appSecret,
                ]);

                if ($tokenResponse->successful() && isset($tokenResponse['id_token'])) {
                    $idToken = $tokenResponse['id_token'];
                    $createResponse = Http::withHeaders([
                        'Authorization' => $idToken,
                        'X-APP-Key' => $appKey,
                    ])->post("{$baseUrl}/tokenized/checkout/create", [
                        'amount' => $order->total_amount,
                        'currency' => 'BDT',
                        'intent' => 'sale',
                        'merchantInvoiceNumber' => $order->order_number,
                    ]);

                    if (isset($createResponse['bkashURL'])) {
                        return [
                            'status' => 'redirect',
                            'redirect_url' => $createResponse['bkashURL'],
                        ];
                    }
                }
            } catch (\Exception $e) {
                Log::error("bKash Live API Error: " . $e->getMessage());
            }
        }

        // Seamless Interactive Gateway Page (for Sandbox / Instant Testing)
        return [
            'status' => 'gateway_page',
            'redirect_url' => route('payment.gateway.page', ['order' => $order->id, 'gateway' => 'bkash']),
        ];
    }

    /**
     * Initiate SSLCommerz / Card Payment
     */
    protected function initiateSSLCommerz(Order $order): array
    {
        $storeId = config('services.sslcommerz.store_id');
        $storePass = config('services.sslcommerz.store_password');
        $isLive = config('services.sslcommerz.mode') === 'live';

        if ($storeId && $storePass) {
            $apiUrl = $isLive ? "https://securepay.sslcommerz.com/gwprocess/v4/api.php" : "https://sandbox.sslcommerz.com/gwprocess/v4/api.php";
            try {
                $postData = [
                    'store_id' => $storeId,
                    'store_passwd' => $storePass,
                    'total_amount' => $order->total_amount,
                    'currency' => "BDT",
                    'tran_id' => $order->order_number,
                    'success_url' => route('payment.callback', ['order' => $order->id, 'gateway' => 'sslcommerz', 'status' => 'success']),
                    'fail_url' => route('payment.callback', ['order' => $order->id, 'gateway' => 'sslcommerz', 'status' => 'fail']),
                    'cancel_url' => route('payment.callback', ['order' => $order->id, 'gateway' => 'sslcommerz', 'status' => 'cancel']),
                    'cus_name' => $order->customer_name,
                    'cus_email' => $order->customer_email,
                    'cus_phone' => $order->customer_phone,
                    'shipping_method' => "NO",
                    'product_name' => "NutriDesk Fruit Subscription",
                    'product_category' => "Subscription",
                    'product_profile' => "general"
                ];

                $response = Http::asForm()->post($apiUrl, $postData);
                $sslcz = json_decode($response->body(), true);

                if (isset($sslcz['GatewayPageURL']) && $sslcz['GatewayPageURL'] != "") {
                    return [
                        'status' => 'redirect',
                        'redirect_url' => $sslcz['GatewayPageURL'],
                    ];
                }
            } catch (\Exception $e) {
                Log::error("SSLCommerz API Error: " . $e->getMessage());
            }
        }

        // Sandbox Gateway Simulation Page
        return [
            'status' => 'gateway_page',
            'redirect_url' => route('payment.gateway.page', ['order' => $order->id, 'gateway' => 'card']),
        ];
    }

    /**
     * Mark Order & Subscription as Paid and send SMS Confirmation
     */
    public function completePayment(Order $order, string $trxId): bool
    {
        $order->update([
            'payment_status' => 'paid',
            'payment_trx_id' => $trxId,
            'status' => 'active',
        ]);

        if ($order->subscription) {
            $order->subscription->update([
                'payment_status' => 'paid',
                'subscription_status' => 'active',
            ]);
        }

        // Trigger SMS Confirmation automatically!
        $this->smsService->sendOrderConfirmation($order);

        return true;
    }
}
