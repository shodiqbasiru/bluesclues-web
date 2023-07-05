<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col">
            {{-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="" class="text-light">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('store.index') }}" class="text-light">Store</a></li>
                    <li class="breadcrumb-item active" aria-current="page">History</li>
                </ol>
            </nav> --}}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="table-responsive">
                <div>
                    <select wire:model="filterStatus" class="form-control">
                        <option value="">All Orders</option>
                        <option value="1">Waiting for Payment</option>
                        <option value="2">Checking Payment</option>
                        <option value="3">Payment Success</option>
                        <option value="4">Cancelled</option>
                    </select>
                </div>
                <table class="table text-center">
                    <thead>
                        <tr>
                            <td>Date of Transaction</td>
                            <td>Order Number</td>
                            <td>Orders</td>
                            <td>Status</td>
                            <td><strong>Total Price</strong></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ \Illuminate\Support\Carbon::parse($order->created_at)->format('d F Y') }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td class="text-left">
                                    @foreach ($order->loadOrderDetailsWithMerchandise as $orderDetail)
                                        <div class="d-flex align-items-center">
                                            <img src="{{ asset('storage/' . $orderDetail->merchandise->image) }}"
                                                class="img-fluid mr-2" width="50">
                                            <span class="mx-2">{{ $orderDetail->merchandise->name }}
                                                <strong>({{ $orderDetail->quantity }})</strong></span>
                                        </div>
                                        <br>
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
                                    @endif

                                    <div>
                                        @if ($order->status != 1 && $order->proof)
                                            <a href="{{ asset('storage/' . $order->proof) }}"
                                                class="btn btn-primary btn-sm" target="_blank">View Proof of Payment</a>
                                        @endif
                                    </div>
                                    <div class="container mt-2">
                                        @if ($order->status == 1)
                                            <a href="{{ route('proof-upload', ['orderId' => $order->id]) }}"
                                                class="btn btn-primary btn-sm">Upload Proof of Payment</a>
                                        @elseif($order->status == 2)
                                            <a href="{{ route('proof-upload', ['orderId' => $order->id]) }}"
                                                class="btn btn-primary btn-sm">Update Proof of Payment</a>
                                        @endif
                                    </div>
                                </td>
                                <td><strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">Data Empty</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="card shadow">
                <div class="card-body">
                    <p>Untuk pembayaran silahkan dapat transfer di rekening dibawah ini : </p>
                    <div class="media">
                        <img class="mr-3" src="{{ url('assets/bri.png') }}" alt="Bank BRI" width="60">
                        <div class="media-body">
                            <h5 class="mt-0">BANK BRI</h5>
                            No. Rekening 012345-678-910 atas nama <strong>Muhammad Afifuddin</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
