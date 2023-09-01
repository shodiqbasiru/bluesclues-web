<div class="coontainer-fluid cart" id="cart">
    <div class="row">
        <div class="col-lg-12">

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('merchandise.home') }}">Home</a></li>
                    <li class="breadcrumb-item active">Shopping Cart</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if (session()->has('message'))
            <div class="alert alert-danger">
                {{ session('message') }}
            </div>
            @endif
        </div>
    </div>
    @if (!$order->isEmpty())
        @foreach ($order as $cart)
            <div class="row">
                <div class="col-md-12">

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col"></th>
                                <th scope="col">Product</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">price</th>
                                <th scope="col">total price</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order_details as $order_detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="image">
                                        <a class="text-decoration-none"
                                        href="{{ route('product.detail', $order_detail->merchandise->slug) }}">
                                        <img src="{{ asset('storage/' . $order_detail->merchandise->image) }}"
                                            alt="Product Image">
                                        </a>
                                    </td>
                                    <td>{{ $order_detail->merchandise->name }}
                                    @if ($order_detail->merchandise->stock < 10)
                                        <br>
                                        <small class="text-danger">In stock: {{ $order_detail->merchandise->stock }}</small>
                                    @endif
                                    </td>
                                    <td>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default btn-sm"
                                                    wire:click="decrementQuantity({{ $order_detail->id }})">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                            </span>
                                            <input type="number" class="form-control input-sm quantity-input"
                                                value="{{ $order_detail->quantity }}"
                                                wire:change="updateQuantity({{ $order_detail->id }}, $event.target.value)"
                                                min="1" max="10">
                                            <span class="input-group-btn">
                                                <button class="btn btn-default btn-sm"
                                                    wire:click="incrementQuantity({{ $order_detail->id }})">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($order_detail->merchandise->price, 0, ',', '.') }}</td>
                                    <td>Rp {{ number_format($order_detail->total_price, 0, ',', '.') }}</td>
                                    <td>
                                        <i class="fas fa-trash text-danger"
                                            wire:click="destroy({{ $order_detail->id }})" style="cursor: pointer"></i>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row cart-total">
                <div class="col-md-7"></div>
                <div class="col-md-5">
                    <h3>Cart Totals</h3>
                    <table class="table">

                        <tbody>
                            @if ($cart)
                                <tr>
                                    <td colspan="3">Subtotal</td>
                                    <td align="right">Rp {{ number_format($cart->total_price, 0, ',', '.') }}</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="3">Weight</td>
                                    <td align="right">~{{ $displayed_weight }} Kg</span></td>
                                    <td></td>
                                </tr>
                                <tr class="total-price">
                                    <td colspan="3">Total</td>
                                    <td align="right">Rp {{ number_format($cart->total_price, 0, ',', '.') }}</td>
                                </tr>
                            @else
                                <tr>
                                    <td align="center" colspan="4">No Item</td>
                                </tr>
                            @endif
                            <tr class=" row-btn">
                                <td colspan="4" align="right">
                                    <a href="{{ route('merchandise.checkout') }}" class="btn-checkout">Proceed to
                                        Checkout</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @else
        <div class="row">
            <div class="col-md-12">

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Image</th>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">price</th>
                            <th scope="col">total price</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td align="center" colspan="7">No Item</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    @endif

</div>
