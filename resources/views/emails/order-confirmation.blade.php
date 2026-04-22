<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #0f5057;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 0 0 8px 8px;
        }
        .order-item {
            background: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 4px solid #0f5057;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            color: #0f5057;
            text-align: center;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ config('settings.site_name', 'Bytte.no') }}</h1>
        <h2>Order Confirmation</h2>
    </div>

    <div class="content">
        <p>Dear Customer,</p>

        <p>Thank you for your order! Your payment has been successfully processed. Here are the details of your order:</p>

        @foreach($orders as $order)
        <div class="order-item">
            <h3>{{ $order->product->title }}</h3>
            <p><strong>Quantity:</strong> {{ $order->quantity }}</p>
            <p><strong>Unit Price:</strong> {{ $order->unit_price }} NOK</p>
            <p><strong>Total:</strong> {{ $order->total_amount }} NOK</p>
            <p><strong>Seller:</strong> {{ $order->seller->name }}</p>
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
        </div>
        @endforeach

        <div class="total">
            Grand Total: {{ $total }} NOK
        </div>

        <p>Your order is being processed. You will receive updates on your order status via email.</p>

        <p>If you have any questions, please contact us at <a href="mailto:{{ config('settings.email', 'support@bytte.no') }}">{{ config('settings.email', 'support@bytte.no') }}</a></p>

        <p>Thank you for shopping with us!</p>

        <p>Best regards,<br>
        {{ config('settings.site_name', 'Bytte.no') }} Team</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} {{ config('settings.site_name', 'Bytte.no') }}. All rights reserved.</p>
    </div>
</body>
</html>