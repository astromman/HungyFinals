<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Status Update</title>
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
            margin-top: 20px;
        }

        .order-status {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #007bff;
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

    <h2>Order Status Update</h2>

    <p>Hello {{ ucwords($buyer->first_name) }},</p>
    <p>We wanted to let you know that the status of your order with reference <strong>{{ $order->order_reference }}</strong> has been updated. Below are the details of your order.</p>

    <div class="order-status">
        <strong>Current Status:
            {{ $order->order_status === 'Ready' ? 'Ready to pick-up' : $order->order_status }}
        </strong>
    </div>


    <div class="order-details">
        <h3>Order Summary</h3>
        <div class="details">
            <span><strong>Order Reference:</strong> {{ $order->order_reference }}</span>
            <br>
            <span><strong>Shop:</strong> {{ $order->product->shop->shop_name }}</span>
            <br>
            <span><strong>Order Date:</strong> {{ $order->created_at->format('D, M d Y, h:i A') }}</span>
        </div>
    </div>

    <h3>Order Breakdown</h3>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orderDetails as $orderDetail)
            <tr>
                <td class="text-uppercase">{{ $orderDetail->productOrder->product_name }}</td>
                <td>{{ $orderDetail->quantity }}x</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>