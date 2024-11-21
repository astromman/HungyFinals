<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .title {
            background-color: #0B1E59;
            font-family: Poppins, sans-serif;
            color: white;
            padding: 1rem;
        }

        .title h1 {
            color: white;
            margin-bottom: 0;
        }

        .subtitle {
            color: white;
            margin-top: 0;
            font-size: 13px;
        }

        h1 {
            color: #0B1E59;
            font-size: 24px;
        }

        p {
            font-size: 16px;
            line-height: 1.5;
        }

        strong {
            color: #0B1E59;
        }

        .details {
            margin-top: 20px;
        }

        .order-status {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border-radius: 8px;
            text-align: center;
            font-size: 18px;
        }

        .order-details {
            margin-top: 20px;
        }

        .text-uppercase {
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <div class="title">
        <h1>Hungry FalCONs</h1>
        <p class="subtitle">Online Ordering Platform</p>
    </div>

    <h2>Payment Confirmation</h2>

    <p>Hello {{ ucwords($buyer->first_name) }},</p>
    <p>We’re pleased to inform you that the payment for your order <strong>{{ $order->order_reference }}</strong> has been confirmed. Below are the details of your order.</p>

    <div class="order-status">
        <strong>Payment Status: Completed</strong>
    </div>

    <div class="order-details">
        <h3>Order Summary</h3>
        <div class="details">
            <span><strong>Order Reference:</strong> {{ $order->order_reference }}</span>
            <br>
            <span><strong>Shop:</strong> {{ $order->product->shop->shop_name }}</span>
            <br>
            <span><strong>Order Date:</strong> {{ $order->created_at->format('D, M d Y, h:i A') }}</span>
            <br>
            <span><strong>Payment Type:</strong> {{ ucwords($order->payment->payment_type) }}</span>
        </div>
    </div>
</body>

</html>
