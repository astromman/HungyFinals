<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <h2>Good day, Concessionaire!</h2>

    <p>This is to inform you:</p>

    <p>Your shop application for <strong>{{ $shop->shop_name }}</strong> has been <strong>{{ $status }}</strong>.</p>

    @if ($status == 'Rejected' && $feedback)
    <p>Reason for rejection: {{ $feedback }}</p>
    @else
    <p>You can now access your online shop as you login.</p>
    @endif

    <p>Thank you for using Hungry FalCONs!</p>

    <p>Best regards,</p>
    <p>The Hungry FalCONs Team</p>
</body>

</html>