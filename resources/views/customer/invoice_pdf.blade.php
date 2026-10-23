<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice - {{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333333;
            font-size: 12px;
            line-height: 1.4;
            padding: 20px;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #10b981;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .company-logo {
            font-size: 26px;
            font-weight: bold;
            color: #065f46;
        }
        .company-logo span {
            color: #10b981;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h2 {
            margin: 0;
            color: #111827;
            font-size: 20px;
        }
        .invoice-title p {
            margin: 3px 0;
            color: #6b7280;
            font-size: 11px;
        }
        .badge {
            background-color: #d1fae5;
            color: #065f46;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            display: inline-block;
        }
        .billing-table {
            width: 100%;
            margin-bottom: 25px;
        }
        .billing-table td {
            vertical-align: top;
            width: 50%;
        }
        .billing-title {
            font-size: 10px;
            text-transform: uppercase;
            color: #9ca3af;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            background-color: #f3f4f6;
            color: #374151;
            padding: 10px;
            text-align: left;
            font-size: 11px;
            text-transform: uppercase;
            border-top: 1px solid #e5e7eb;
            border-bottom: 1px solid #e5e7eb;
        }
        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #f3f4f6;
        }
        .totals-table {
            width: 100%;
            margin-top: 10px;
        }
        .totals-table td {
            padding: 5px 0;
        }
        .totals-table .label {
            text-align: right;
            padding-right: 20px;
            color: #4b5563;
        }
        .totals-table .val {
            text-align: right;
            font-weight: bold;
            width: 120px;
        }
        .total-row {
            border-top: 2px solid #e5e7eb;
            font-size: 14px;
            color: #059669;
        }
        .footer {
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e5e7eb;
            font-size: 10px;
            color: #9ca3af;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td>
                <div class="company-logo">Nutri<span>Desk</span></div>
                <div style="font-size: 10px; color: #6b7280; margin-top: 4px;">
                    Daily Fresh Fruit Desk Delivery Service<br>
                    Plot 12, Road 4, Gulshan-2, Dhaka-1212 &bull; Hotline: +880 1700-000001
                </div>
            </td>
            <td class="invoice-title">
                <h2>INVOICE #{{ $order->order_number }}</h2>
                <p>Date: {{ $order->created_at->format('d M Y') }}</p>
                <div style="margin-top: 5px;">
                    <span class="badge">PAID ({{ strtoupper($order->payment_method) }})</span>
                </div>
            </td>
        </tr>
    </table>

    <!-- Billing Info -->
    <table class="billing-table">
        <tr>
            <td>
                <div class="billing-title">BILLED TO (CUSTOMER):</div>
                <div style="font-weight: bold; font-size: 13px;">{{ $order->customer_name }}</div>
                <div>Phone: {{ $order->customer_phone }}</div>
                <div>Email: {{ $order->customer_email }}</div>
            </td>
            <td>
                <div class="billing-title">OFFICE DESK DESTINATION:</div>
                <div style="font-weight: bold; font-size: 13px;">{{ $order->subscription->delivery_office_name ?? $order->delivery_address }}</div>
                <div>Floor: {{ $order->subscription->delivery_floor ?? 'N/A' }}, Desk: {{ $order->subscription->delivery_desk ?? 'N/A' }}</div>
                <div style="color: #059669; font-weight: bold;">Preferred Slot: {{ $order->subscription->delivery_time_slot ?? '10:00 AM - 11:30 AM' }}</div>
            </td>
        </tr>
    </table>

    <!-- Items -->
    <table class="items-table">
        <thead>
            <tr>
                <th>Description</th>
                <th style="text-align: center;">Dietary Condition</th>
                <th style="text-align: center;">Persons</th>
                <th style="text-align: center;">Duration</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div style="font-weight: bold;">{{ $order->package ? $order->package->name_en : 'Fruit Subscription' }}</div>
                    <div style="font-size: 10px; color: #6b7280;">Daily {{ $order->subscription->daily_grams ?? 130 }}g portioned fresh cut fruits in food-grade bowl</div>
                </td>
                <td style="text-align: center; text-transform: capitalize;">
                    {{ $order->subscription->health_condition ?? 'general' }}
                </td>
                <td style="text-align: center;">
                    {{ $order->subscription->total_persons ?? 1 }}
                </td>
                <td style="text-align: center;">
                    {{ $order->subscription && $order->subscription->plan_duration === '7_days' ? '7 Days Trial' : '1 Month (22 Days)' }}
                </td>
                <td style="text-align: right; font-weight: bold;">
                    BDT {{ number_format($order->subtotal, 2) }}
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Totals -->
    <table class="totals-table">
        <tr>
            <td style="width: 60%;"></td>
            <td class="label">Subtotal:</td>
            <td class="val">BDT {{ number_format($order->subtotal, 2) }}</td>
        </tr>
        <tr>
            <td></td>
            <td class="label">Desk Delivery:</td>
            <td class="val" style="color: #10b981;">FREE</td>
        </tr>
        <tr>
            <td></td>
            <td class="label">VAT / Tax (Included 5%):</td>
            <td class="val">BDT {{ number_format(($order->total_amount * 0.05), 2) }}</td>
        </tr>
        <tr class="total-row">
            <td></td>
            <td class="label" style="font-weight: bold; color: #111827;">Total Paid:</td>
            <td class="val">BDT {{ number_format($order->total_amount, 2) }}</td>
        </tr>
    </table>

    <!-- Footer -->
    <div class="footer">
        Payment Gateway TrxID: {{ $order->payment_trx_id ?? 'AUTO_GENERATED' }} &bull; Paid on {{ $order->created_at->format('d M Y, h:i A') }}<br>
        Thank you for choosing NutriDesk! Eating 100g fruit daily keeps you energetic and healthy.
    </div>

</body>
</html>
