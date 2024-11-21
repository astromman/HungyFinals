<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Completed</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th {
            border: 0;
        }

        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #0B1E59;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        strong {
            color: #0B1E59;
        }

        .details {
            display: flex;
            align-items: flex-start;
            /* Ensures proper alignment of items */
            justify-content: space-between;
            /* Makes space between items */
            margin-top: 20px;
        }

        .order-details {
            flex: 1;
        }

        .total-amount {
            text-align: right;
            align-items: flex-end;
            flex: 0;
        }

        .total-amount .amount {
            color: #007bff;
            font-size: 2rem;
        }

        .total-amount p {
            margin: 0;
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

    <h2>Your Order Receipt</h2>

    <p>Thank you for ordering from {{ $orderDetails->first()->product->shop->shop_name }}. Your order has been completed.</p>

    <div class="details" style="display: flex; justify-content: space-between; align-items: center;">
        <div class="order-details" style="width: 60%;">
            <span>Order Reference: {{ $orderDetails->first()->order_reference }}</span>
            <br>
            <span>Payment Method:
                <span class="text-uppercase">
                    {{ $orderDetails->first()->payment_type }}
                </span>
            </span>
            <br>
            <span>{{ $orderDetails->first()->created_at->format('D, M d Y, h:i A') }}</span>
        </div>
        <div class="total-amount" style="width: 40%; text-align: right;">
            <p style="margin: 0;">
                Total Amount
                <br>
                <span style="color: #007bff; font-size: 2rem;">
                    ₱ {{ number_format($orderDetails->sum('total'), 2) }}
                </span>
            </p>
        </div>
    </div>

    <h2>Order Breakdown</h2>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orderDetails as $order)
            <tr>
                <td class="text-uppercase">{{ $order->productOrder->product_name }}</td>
                <td>{{ $order->quantity }}x</td>
                <td>₱ {{ number_format($order->productOrder->price, 2) }}</td>
                <td>₱ {{ number_format($order->productOrder->price * $order->quantity, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>