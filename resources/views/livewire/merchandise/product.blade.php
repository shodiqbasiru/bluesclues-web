<div class="container-fluid page-store" id="products">

    {{-- <div class="filter text-center">
        @foreach ($categories as $category)
            <a href="{{ route('product.category', $category->id) }}" wire:click="selectCategory({{ $category->id }})"
                class="btn-filter{{ $selectedCategoryId == $category->id ? ' active' : '' }}">{{ $category->name }}</a>
        @endforeach
    </div> --}}

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
            @foreach ($products as $product)
                <a href="{{ route('product.detail', $product->slug) }}">
                    <div class="card">
                        <img src="{{ url('./assets/img/bc-1.png') }}" class="card-img-top" alt="...">
                        <button class="btn">Detail</button>
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-price">rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
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
