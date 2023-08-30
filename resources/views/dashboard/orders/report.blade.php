<!DOCTYPE html>
<html>

<head>
    <title>Orders Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }

        .report-created {
            position: absolute;
            top: 5px;
            right: 5px;
            text-align: right;
            font-size: 6pt;
        }

        header .logo-report h1 {
            font-size: 24px;
        }
    </style>

    <header>
        <div class="logo-report">
            <h1>Blues Clues</h1>
        </div>
        <div class="report-created">
            @php
                $currentTime = \Carbon\Carbon::now('Asia/Jakarta')->format('F j, Y \a\t h:i A');
            @endphp
            <p>Report generated on {{ $currentTime }} (UTC+7)</p>
        </div>

    </header>
    <center>
        <h4>Orders Report</h4>
    </center>

    <div class="mb-3 mt-3">
        @if ($status)
            @php
                $statusText = '';
                if ($status === 'waiting-for-payment') {
                    $statusText = 'Waiting For Payment Orders';
                } elseif ($status === 'checking-payment') {
                    $statusText = 'Checking Payment Orders';
                } elseif ($status === 'success') {
                    $statusText = 'Payment Success Orders';
                } elseif ($status === 'cancelled') {
                    $statusText = 'Cancelled Orders';
                } elseif ($status === 'shipping') {
                    $statusText = 'Shipping Orders';
                } elseif ($status === 'product-received') {
                    $statusText = 'Product Received Orders';
                }
            @endphp
            <h5> {{ $statusText }} Report</h5>
        @endif

        @if ($month && $selectedYear)
            <h5> {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $selectedYear }}</h5>
        @endif

        @if ($selectedYearOnly)
            <h5> {{ $selectedYearOnly }}</h5>
        @endif

        @if (!$status && !$month && !$selectedYear && !$selectedYearOnly)
            <h5>All Orders</h5>
        @endif
    </div>

    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date of Transaction</th>
                <th scope="col">Customer Name</th>
                <th scope="col">Order Number</th>
                <th scope="col">Orders</th>
                <th scope="col">Status</th>
                <th scope="col">Total Price</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($orders as $order)
                <tr>
                    <td>
                        {{ $loop->iteration }}
                    </td>
                    <td>{{ \Illuminate\Support\Carbon::parse($order->created_at)->format('d F Y') }}
                    </td>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->order_number }}</td>
                    <td>
                        @foreach ($order->orderDetails->take(3) as $orderDetail)
                            <div>
                                <span class="mx-2">{{ $orderDetail->merchandise->name }}
                                    <strong>({{ $orderDetail->quantity }})</strong></span>
                            </div>
                        @endforeach
                    </td>
                    <td>
                        @if ($order->status == 1)
                            <span class="badge badge-warning">
                                Waiting for Payment
                            </span>
                        @elseif($order->status == 2)
                            <span class="badge badge-info">
                                Checking Payment
                            </span>
                        @elseif($order->status == 3)
                            <span class="badge badge-success">
                                Payment Success
                            </span>
                        @elseif($order->status == 4)
                            <span class="badge badge-danger">
                                Cancelled
                            </span>
                        @elseif($order->status == 5)
                            <span class="badge badge-primary">
                                Shipping
                            </span>
                        @elseif($order->status == 6)
                            <span class="badge badge-primary">
                                Product Received
                            </span>
                        @endif
                    </td>
                    <td><strong>Rp {{ number_format($order->total_price + , 0, ',', '.') }}</strong></td>
                </tr>

            @empty
                <tr>
                    <td colspan="7">Data Empty</td>
                </tr>

            @endforelse
            <tr>
                <td align="center" colspan="6"><strong>Total Price</strong></td>
                <td>Rp {{ number_format($totalPrice, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>
</body>
