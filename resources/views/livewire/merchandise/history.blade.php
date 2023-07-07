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
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <div class="col">
            <div class="table-responsive">
                <div class="col-md-2">
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
                        </ul>
                    </div>
                </div>
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
                                            <a href="{{ asset('storage/' . $order->proof) }}" target="_blank"><i
                                                    class="fas fa-eye"></i></a>
                                        @endif

                                        @if ($order->status == 1)
                                            <a href="{{ route('proof-upload', ['orderId' => $order->id]) }}"><i
                                                    class="fas fa-upload"></i></a>
                                        @elseif($order->status == 2)
                                            <a href="{{ route('proof-upload', ['orderId' => $order->id]) }}"><i
                                                    class="fas fa-edit"></i></a>
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
                                        <p>
                                            Payment Success
                                        </p>
                                    @elseif($order->status == 4)
                                        <p>
                                            Cancelled
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


{{-- <div class="custom-option" wire:click="$set('filterStatus', ''); $set('isActiveFilter', '')"
    @class(['active' => $isActiveFilter === ''])>All Orders</div>
<div class="custom-option" wire:click="$set('filterStatus', '1'); $set('isActiveFilter', '1')"
    @class(['active' => $isActiveFilter === '1'])>Waiting for Payment</div>
<div class="custom-option" wire:click="$set('filterStatus', '2'); $set('isActiveFilter', '2')"
    @class(['active' => $isActiveFilter === '2'])>Checking Payment</div>
<div class="custom-option" wire:click="$set('filterStatus', '3'); $set('isActiveFilter', '3')"
    @class(['active' => $isActiveFilter === '3'])>Payment Success</div>
<div class="custom-option" wire:click="$set('filterStatus', '4'); $set('isActiveFilter', '4')"
    @class(['active' => $isActiveFilter === '4'])>Cancelled</div> --}}
