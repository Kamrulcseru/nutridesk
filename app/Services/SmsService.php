<?php

namespace App\Services;

use App\Models\DailyDelivery;
use App\Models\Order;
use App\Models\SmsLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send an SMS to a phone number.
     */
    public function send(string $phone, string $message, string $type = 'general', ?int $userId = null): bool
    {
        // Sanitize phone number (e.g. +88017XXXXXXXX or 017XXXXXXXX)
        $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($cleanPhone) === 11 && str_starts_with($cleanPhone, '01')) {
            $cleanPhone = '88' . $cleanPhone;
        }

        $gateway = config('services.sms.gateway', 'mock');
        $success = false;
        $responsePayload = null;

        try {
            if ($gateway === 'greenweb') {
                $token = config('services.sms.greenweb_token');
                $response = Http::post('http://api.greenweb.com.bd/api.php', [
                    'token' => $token,
                    'to' => $cleanPhone,
                    'message' => $message,
                ]);
                $responsePayload = $response->body();
                $success = $response->successful();
            } elseif ($gateway === 'bulksmsbd') {
                $apiKey = config('services.sms.bulksms_api_key');
                $senderId = config('services.sms.bulksms_sender_id');
                $response = Http::get('http://bulksmsbd.net/api/smsapi', [
                    'api_key' => $apiKey,
                    'type' => 'text',
                    'number' => $cleanPhone,
                    'senderid' => $senderId,
                    'message' => $message,
                ]);
                $responsePayload = $response->body();
                $success = $response->successful();
            } else {
                // Mock / Local log gateway for testing
                $responsePayload = json_encode(['status' => 'mock_delivered', 'timestamp' => now()->toDateTimeString()]);
                $success = true;
                Log::info("NutriDesk SMS -> To: {$cleanPhone} | Message: {$message}");
            }
        } catch (\Exception $e) {
            $responsePayload = $e->getMessage();
            $success = false;
            Log::error("NutriDesk SMS Exception: " . $e->getMessage());
        }

        // Record in database sms_logs table
        SmsLog::create([
            'user_id' => $userId,
            'phone' => $phone,
            'message' => $message,
            'type' => $type,
            'gateway' => $gateway,
            'status' => $success ? 'sent' : 'failed',
            'response_payload' => $responsePayload,
        ]);

        return $success;
    }

    /**
     * Trigger 1: Order and Subscription Confirmation SMS
     */
    public function sendOrderConfirmation(Order $order): bool
    {
        $name = $order->customer_name;
        $orderNum = $order->order_number;
        $startDate = $order->subscription ? $order->subscription->start_date->format('d M') : date('d M');

        $msg = "ধন্যবাদ {$name}! NutriDesk এ আপনার অর্ডার #{$orderNum} নিশ্চিত হয়েছে। {$startDate} থেকে সকাল ১১টার মধ্যে ফ্রেশ ফলের বাউল আপনার ডেস্কে পৌঁছাবে। হেল্পলাইন: 01700000001";

        return $this->send($order->customer_phone, $msg, 'order_confirmation', $order->user_id);
    }

    /**
     * Trigger 2: Out for delivery SMS
     */
    public function sendOutForDelivery(DailyDelivery $delivery): bool
    {
        $sub = $delivery->subscription;
        if (!$sub) return false;

        $name = $sub->user->name ?? 'গ্রাহক';
        $rider = $delivery->delivery_person ?? 'আমাদের রাইডার';
        $fruits = $delivery->fruits_summary ?? 'আজকের ফ্রেশ ফ্রুট বাউল';

        $msg = "প্রিয় {$name}, আপনার আজকের ফ্রেশ ফল ({$fruits}) নিয়ে রাইডার {$rider} ডেস্কে পৌঁছানোর পথে আছেন। শীঘ্রই ডেস্কে রিসিভ করুন।";

        return $this->send($sub->delivery_phone, $msg, 'out_for_delivery', $sub->user_id);
    }

    /**
     * Trigger 3: Delivered at Desk SMS
     */
    public function sendDelivered(DailyDelivery $delivery): bool
    {
        $sub = $delivery->subscription;
        if (!$sub) return false;

        $name = $sub->user->name ?? 'গ্রাহক';
        $desk = $sub->delivery_desk ?? 'ডেস্ক';

        $msg = "প্রিয় {$name}, আপনার আজকের NutriDesk ফলের বাউল আপনার {$desk} এ সফলভাবে পৌঁছে দেওয়া হয়েছে। স্বাস্থ্যকর দিন কাটুক!";

        return $this->send($sub->delivery_phone, $msg, 'delivered', $sub->user_id);
    }

    /**
     * Trigger 4: Delivery Paused confirmation SMS
     */
    public function sendPaused(DailyDelivery $delivery): bool
    {
        $sub = $delivery->subscription;
        if (!$sub) return false;

        $name = $sub->user->name ?? 'গ্রাহক';
        $date = date('d M', strtotime($delivery->delivery_date));

        $msg = "প্রিয় {$name}, আপনার {$date} তারিখের ডেলিভারি সফলভাবে পজ করা হয়েছে। এই দিনটির জন্য আপনার সাবস্ক্রিপশনের শেষে ১টি অতিরিক্ত দিন যোগ হয়েছে।";

        return $this->send($sub->delivery_phone, $msg, 'paused', $sub->user_id);
    }
}
