<div class="container-fluid" id="checkout">
    <div class="row">
        <div class="col-lg-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('merchandise.home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('merchandise.cart') }}">Shopping Cart</a></li>
                    <li class="breadcrumb-item active">Checkout</li>
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

    <div class="row mt-4">

        <div class="col">
            <h4>Billing details</h4>
            <form wire:submit.prevent="checkout" id="checkoutForm">

                <div class="form-group">
                    <label for="name">Full Name<span>*</span></label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        wire:model="name" value="{{ old('name') }}" autocomplete="name" autofocus>


                    @if ($errors->has('name'))
                        <span class="error" role="alert">
                            <strong>{{ $errors->getBag('default')->first('name') ?? $messages['postal_code.required'] }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number<span>*</span></label>
                    <input id="phone_number" type="text"
                        class="form-control @error('phone_number') is-invalid @enderror" wire:model="phone_number"
                        value="{{ old('phone_number') }}" autocomplete="name" autofocus>

                    @if ($errors->has('phone_number'))
                        <span class="error" role="alert">
                            <strong>{{ $errors->getBag('default')->first('phone_number') ?? $messages['postal_code.required'] }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="province_dest">Province<span>*</span></label>
                    <select wire:model="province_dest"
                        class="form-control  @error('province_dest') is-invalid @enderror">
                        <option class="select-list" value="">-- Select Province --</option>
                        @foreach ($provinces as $province => $value)
                            <option class="select-list " value="{{ $province }}"
                                {{ $province_dest == $province ? 'selected' : '' }}>
                                {{ $value }}
                                </option>
                        @endforeach
                    </select>
                    @if ($errors->has('province_dest'))
                        <span class="error" role="alert">
                            <strong>{{ $errors->getBag('default')->first('province_dest') ?? $messages['province_dest.required'] }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="city_dest">City<span>*</span></label>
                    <select wire:model="city_dest" class="form-control @error('city_dest') is-invalid @enderror">
                        <option value="" class="select-list ">-- Select City --</option>
                        @foreach ($cities as $city => $name)
                            <option class="select-list" value="{{ $city }}"
                                {{ $city_dest == $city ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                    @if ($errors->has('city_dest'))
                        <span class="error" role="alert">
                            <strong>{{ $errors->getBag('default')->first('city_dest') ?? $messages['city_dest.required'] }}</strong>
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="address">Full Address<span>*</span></label>
                    <textarea wire:model="address" class="form-control @error('address') is-invalid @enderror"></textarea>

                    @if ($errors->has('address'))
                        <span class="error" role="alert">
                            <strong>{{ $errors->getBag('default')->first('address') ?? $messages['postal_code.required'] }}</strong>
                        </span>
                    @endif
                </div>



                <div class="form-group">
                    <label for="postal_code">Postal Code<span>*</span></label>
                    <input id="postal_code" type="number"
                        class="form-control @error('postal_code') is-invalid @enderror" wire:model="postal_code"
                        value="{{ old('postal_code') }}" autocomplete="name" autofocus>

                    @if ($errors->has('postal_code'))
                        <span class="error" role="alert">
                            <strong>{{ $errors->getBag('default')->first('postal_code') ?? $messages['postal_code.required'] }}</strong>
                        </span>
                    @endif


                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea wire:model="notes" class="form-control @error('notes') is-invalid @enderror"></textarea>

                    @error('notes')
                        <span class="error" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row billing-order justify-content-between">
                    @foreach ($orders as $order)
                        <div class="col-12">
                            <h4>Your Order</h4>
                        </div>
                        <div class="col-lg-4 col-12">
                            <h5>Product</h5>
                            <div class="list-products">
                                @foreach ($order_details as $index => $order_detail)
                                    @if ($index < 1)
                                        <div class="item-product">
                                            <img src="{{ asset('storage/' . $order_detail->merchandise->image) }}"
                                                alt="Product Image">
                                            <div class="item-name">
                                                <p>{{ $order_detail->merchandise->name }}</p>
                                                <p class="qty">Qty: {{ $order_detail->quantity }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                <div class="more-products">
                                    <p>
                                        Total products: {{ $total_quantity }}
                                    </p>
                                    <button type="button" class="btn-checkout" data-bs-toggle="modal"
                                        data-bs-target="#listProducts">
                                        show more products...
                                    </button>

                                    <div class="modal fade" id="listProducts" tabindex="-1"
                                        aria-labelledby="listProductsLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="listProductsLabel">Detail
                                                        Products
                                                    </h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col" width="20%"
                                                                    class="text-center">#
                                                                </th>
                                                                <th scope="col" width="80%">Name</th>
                                                                <th scope="col" width="20%">qty</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($order_details as $order_detail)
                                                                <tr class="items">
                                                                    <th scope="row">
                                                                        <img src="{{ asset('storage/' . $order_detail->merchandise->image) }}"
                                                                            alt="Product Image">
                                                                    </th>
                                                                    <td>
                                                                        <div class="cell-content">

                                                                            {{ $order_detail->merchandise->name }}
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="cell-content">
                                                                            x{{ $order_detail->quantity }}
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @endforeach

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5 col-12 pay">
                            <h5>Total</h5>
                            <table class="table">

                                <tbody>
                                    <tr>
                                        <td colspan="3">Total Order Cost</td>
                                        <td align="right">Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                    </tr>
                                    @if ($courier)
                                        <tr>
                                            <td colspan="3">Courier</td>
                                            <td align="right">{{ $courier }}: {{ $service }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                    <tr>
                                        <td colspan="3">Shipping fee</td>
                                        @if ($cost)
                                            <td align="right">Rp {{ number_format($cost, 0, ',', '.') }}</td>
                                        @else
                                            <td align="right">-</td>
                                        @endif
                                    </tr>
                                    <tr>
                                        <td colspan="3">Total Weight</td>
                                        <td align="right">~{{ $displayed_weight }}
                                            Kg</span>
                                        </td>
                                    </tr>
                                    <tr class="total-price">
                                        <td colspan="3">Total Cost (Order + Shipping)</td>
                                        <td align="right">Rp
                                            {{ number_format($order->total_price + $cost, 0, ',', '.') }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="button" colspan="4" align="right" style="border:none">
                                            @if ($errors->any())
                                                <div class="alert alert-danger mt-2 text-center alert-dismissible fade show my-2"
                                                    role="alert">
                                                    Please correct the errors above before submitting.
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            @endif

                                            <div wire:loading.class="loading-spinner">
                                            </div>

                                            <div wire:loading.remove>
                                                <!-- Display the shipping cost data or other content -->
                                                @if ($shippingAvailable)
                                                    <button type="submit" class="btn-checkout" style="">
                                                        Pay now
                                                    </button>
                                                @else
                                                    <div class="alert alert-danger mt-2 text-center" role="alert">
                                                        The selected city is currently unavailable for shipping. We
                                                        apologize for
                                                        the inconvenience. Please consider selecting an alternate city
                                                        or contact
                                                        our customer support for assistance.
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endforeach
                </div>

            </form>
        </div>
    </div>
