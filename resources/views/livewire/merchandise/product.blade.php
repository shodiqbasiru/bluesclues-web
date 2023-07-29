<div class="container-fluid page-store" id="products">

    <div class="content">
        <div class="header">
            <h2>{{ $title }}</h2>
            <div class="input-group">
                <input wire:model="search" type="text" class="form-control" placeholder="Search . . ." aria-label="Search"
                    aria-describedby="basic-addon1">
                <span class="input-group-text" id="basic-addon1">
                    <i class="fas fa-search"></i>
                </span>
            </div>
        </div>
        <div class="body">
            @if ($products->isEmpty())
                <p class="mx-auto text-center h4">No Product Found</p>
            @else
                @foreach ($products as $product)
                    <a href="{{ route('product.detail', $product->slug) }}">
                        <div class="card">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                alt="{{ $product->name }}">
                            <button class="btn">Detail</button>
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-price">rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            @if ($product->is_available != 1)
                                <span class="sold-out">
                                    sold out
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            @endif
        </div>
        <div class="pagination">
            <div class="showing-items">
                Showing {{ $products->firstItem() }} - {{ $products->lastItem() }} of {{ $products->total() }} items
            </div>
            <div class="page">
                {{ $products->links() }}
            </div>
        </div>
    </div>


</div>
