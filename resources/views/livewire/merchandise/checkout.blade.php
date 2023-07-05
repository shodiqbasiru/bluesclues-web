<div class="container">
    <div class="row mt-4 mb-2">
        <div class="col">
            {{-- <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('store.index') }}" class="text-light">Store</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cart.index') }}" class="text-light">Cart</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Check Out</li>
                </ol>
            </nav> --}}
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

    <div class="row">
        <div class="col">
            <a href="{{ route('merchandise.cart') }}" class="btn btn-sm btn-dark"> Back</a>
        </div>
    </div>

    <div class="row mt-4">

        <div class="col">
            <h4>Shipping Information</h4>
            <hr>
            <form wire:submit.prevent="checkout">

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                        wire:model="name" value="{{ old('name') }}" autocomplete="name" autofocus>

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone_number">Phone Number</label>
                    <input id="phone_number" type="text"
                        class="form-control @error('phone_number') is-invalid @enderror" wire:model="phone_number"
                        value="{{ old('phone_number') }}" autocomplete="name" autofocus>

                    @error('phone_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Full Address</label>
                    <textarea wire:model="address" class="form-control @error('address') is-invalid @enderror"></textarea>

                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="postal_code">Postal Code</label>
                    <input id="postal_code" type="number"
                        class="form-control @error('postal_code') is-invalid @enderror" wire:model="postal_code"
                        value="{{ old('postal_code') }}" autocomplete="name" autofocus required>

                    @error('postal_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea wire:model="notes" class="form-control @error('notes') is-invalid @enderror"></textarea>

                    @error('notes')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success btn-block"> <i class="fas fa-arrow-right"></i> Checkout
                </button>
            </form>
        </div>
    </div>
</div>
