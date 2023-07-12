<div class="container-fluid" id="history">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('merchandise.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">History</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('message') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

                </div>
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="dropdown">
                <button class="dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    {{ $statusLabel }}
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item" wire:click="setFilterStatus('')">All Orders</a></li>
                    <li><a class="dropdown-item" wire:click="setFilterStatus('1')">Waiting for Payment</a></li>
                    <li><a class="dropdown-item" wire:click="setFilterStatus('2')">Checking Payment</a></li>
                    <li><a class="dropdown-item" wire:click="setFilterStatus('3')">Payment Success</a></li>
                    <li><a class="dropdown-item" wire:click="setFilterStatus('4')">Cancelled</a></li>
                    <li><a class="dropdown-item" wire:click="setFilterStatus('5')">Shipping</a></li>
                    <li><a class="dropdown-item" wire:click="setFilterStatus('6')">Product Received</a></li>
                </ul>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" class="numbers" width="5%">No</th>
                            <th scope="col" width="10%">Date</th>
                            <th scope="col" width="10%">Id Order</th>
                            <th scope="col" width="20%">Orders</th>
                            <th scope="col" width="15%">proof of payment</th>
                            <th scope="col" width="20%">Status</th>
                            <th scope="col" width="20%"><strong>Total Price</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td align="center">{{ $loop->iteration }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($order->created_at)->format('d F Y') }}</td>
                                <td>{{ $order->order_number }}</td>
                                <td class="orders">
                                    @foreach ($order->loadOrderDetailsWithMerchandise as $orderDetail)
                                        <div class="products">
                                            {{-- <img src="{{ asset('storage/' . $orderDetail->merchandise->image) }}"
                                                class="img-fluid mr-2" width="50"> --}}
                                            <img src="{{ url('./assets/img/bc-1.png') }}" alt="Product Image">
                                            <div class="text">
                                                <p>{{ $orderDetail->merchandise->name }}
                                                </p>
                                                <p>{{ $orderDetail->quantity }}</p>
                                            </div>
                                        </div>
                                        <br>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="icon-status">

                                        @if ($order->status != 1 && $order->proof)
                                            @if ($order->status != 5 && $order->status != 6)
                                                <a href="{{ asset('storage/' . $order->proof) }}" target="_blank"><i
                                                        class="fas fa-eye"></i></a>
                                            @endif
                                        @endif
                                        @if ($order->status == 1)
                                            <a href="{{ route('proof-upload', ['orderId' => $order->id]) }}"><i
                                                    class="fas fa-upload"></i></a>
                                            <button class="btn-cancel" wire:click="cancelOrder('{{ $order->id }}')"
                                                wire:loading.remove wire:target="cancelOrder('{{ $order->id }}')"><i
                                                    class="fas fa-ban"></i> Cancel</button>
                                            <span wire:loading
                                                wire:target="cancelOrder('{{ $order->id }}')">Canceling...</span>
                                        @elseif($order->status == 2)
                                            <a href="{{ route('proof-upload', ['orderId' => $order->id]) }}"><i
                                                    class="fas fa-edit"></i></a>
                                        @elseif($order->status == 4)
                                            -
                                        @elseif($order->status == 5)
                                            <button class="btn-receive"
                                                wire:click="receiveOrder('{{ $order->id }}')" wire:loading.remove
                                                wire:target="receiveOrder('{{ $order->id }}')"><i
                                                    class="fas fa-check"></i> Pesanan Diterima</button>
                                            <span wire:loading
                                                wire:target="receiveOrder('{{ $order->id }}')">Menerima
                                                Pesanan...</span>
                                        @else
                                            -
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if ($order->status == 1)
                                        <p>
                                            Waiting for Payment
                                        </p>
                                    @elseif($order->status == 2)
                                        <p>
                                            Checking Payment
                                        </p>
                                    @elseif($order->status == 3)
                                        <p class="text-success">
                                            Payment Success
                                        </p>
                                    @elseif($order->status == 4)
                                        <p class="text-cancel">
                                            Cancelled
                                        </p>
                                    @elseif($order->status == 5)
                                        <p>
                                            Shipping
                                        </p>
                                    @elseif($order->status == 6)
                                        <p class="text-success">
                                            Product Received
                                        </p>
                                    @endif
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


</div>
