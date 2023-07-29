<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Order Notification</title>
    <style>
        /* Styles for the card */
        .card {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
            text-align: center;
        }

        /* Styles for the table */
        table {
            margin-top: 20px;
            width: 100%;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>New Order Notification</h2>
        <p>A new order has been placed. Here are the details:</p>
        @foreach ($order as $order)
        <table>
            <tr>
                <th>Order Number:</th>
                <td>{{ $order->order_number }}</td>
            </tr>
            <tr>
                <th>Order Date:</th>
                <td>{{ \Illuminate\Support\Carbon::parse($order->created_at)->format('d F Y') }}</td>
            </tr>
            <tr>
                <th>Customer Name:</th>
                <td>{{ $name }}</td>
            </tr>
            <tr>
                <th>Customer Email:</th>
                <td>{{ $email }}</td>
            </tr>
            <!-- Add more order details here -->
        </table>
        <div class="order">
            <h3 class="text-center">Order Details</h3>
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $orderDetail)
                        <tr>
                            <td class="align-middle">{{ $orderDetail->merchandise->name }}
                            </td>
                            <td class="align-middle">{{ $orderDetail->quantity }}
                            </td>
                            <td class="align-middle" id="total-price-{{ $orderDetail->id }}">
                                Rp {{ number_format($orderDetail->total_price, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    <tbody>
                </table>
                <div id="total-price-display">
                    <h4 class="text-end">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>
        @endforeach

        <p>Please take appropriate action and process the order accordingly.</p>

        <p>Thank you!</p>
    </div>
</body>
</html>
