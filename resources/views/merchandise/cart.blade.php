@extends('merchandise.layouts.main')

@section('content')
<div class="container-fluid page-store d-flex justify-content-center">
    <div class="content">
        @if (!$cart->isEmpty())
        @foreach ($cart as $order)
        <div class="order">
            <h3 class="text-center">Your Cart</h3>
            <div class="table-responsive">
                <table class="table text-center">
                    <thead>
                        <tr>
                            <th colspan="2" scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->orderDetails as $orderDetail)
                        <tr>
                            <td class="align-middle"><img
                                    src="{{  asset('storage/' . $orderDetail->merchandise->image) }}" class="img-fluid"
                                    width="150" alt="..."></td>
                            <td class="align-middle">{{ $orderDetail->merchandise->name }}
                            </td>
                            <td class="align-middle">
                                <div class="quantity-control">
                                    <form action="{{ route('cart.decreaseQuantity', $orderDetail->id) }}" method="post"
                                        class="d-inline">
                                        @method('patch')
                                        @csrf
                                        <button type="submit" class="decrement">-</button>
                                    </form>
                                    <input type="number" value="{{ $orderDetail->quantity }}" id="quantity-select"
                                        min="1" max="10" value="1" name="quantity-select" readonly>
                                    <form action="{{ route('cart.increaseQuantity', $orderDetail->id) }}" method="post"
                                        class="d-inline">
                                        @method('patch')
                                        @csrf
                                        <button type="submit" class="increment">+</button>
                                    </form>
                                </div>
                            </td>
                            <td class="align-middle" id="total-price-{{ $orderDetail->id }}">
                                Rp {{ number_format($orderDetail->total_price, 0, ',', '.') }}
                            </td>
                            <td class="align-middle">
                                <form action="{{ route('cart.destroy', $orderDetail->id) }}" method="post"
                                    class="d-inline">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-outline-light me-2 text-danger"
                                        onclick="return confirm ('Are you sure to delete this entry?')">X</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    <tbody>
                </table>
                <div id="total-price-display">
                    <h4 class="text-end">Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</h4>
                </div>

                <div>
                    <a href="{{ route('checkout') }}" class="btn btn-merchan">
                        Checkout
                    </a>
                </div>
            </div>
        </div>
        @endforeach
        @else

        <div class="text-center">
            <p>Your Cart is empty</p>
        </div>
        @endif
    </div>
</div>


@endsection