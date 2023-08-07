@extends('dashboard.layouts.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        @if ($categoryName)
        All {{ $categoryName }}
        @else
        All Products
        @endif
    </h1>
</div>
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show my-2" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="d-flex justify-content-between">
    <div>
        <a href="/admin/dashboard/merchandise/create" class="btn-primary-dashboard mb-3"><i
                class="fas fa-circle-plus"></i> Add products</a>
        <div class="mt-3">
            <form action="{{ route('merchandise.index') }}" method="GET" style="margin-right: 24px">
                <div class="btn-group btn-no-space mb-3" role="group" aria-label="Filter Products">
                    <button type="button" class="btn-primary-dashboard dropdown-toggle" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter By Category
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item{{ empty($category) ? ' active' : '' }}"
                            href="{{ route('merchandise.index', ['category' => '']) }}">All</a>

                        @foreach ($categories as $itemcategory)
                        <a class="dropdown-item{{ $category == $itemcategory->id ? ' active' : '' }}"
                            href="{{ route('merchandise.index', ['category' => $itemcategory->id]) }}">{{
                            $itemcategory->name }}</a>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
    </div>
    <form action="{{ route('merchandise.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search products"
                value="{{ $searchQuery ?? '' }}">
            <button type="submit" class="btn-filter-dashboard"><i class="fas fa-search"></i></button>
        </div>
    </form>
</div>
<div class="table-responsive">

    @if ($searchQuery)
    <div class="mb-3">
        <h5>Results for: "{{ $searchQuery }}"</h5>
    </div>
    @endif

    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Category</th>
                <th scope="col">Price</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($merchandise as $item)
            <tr>
                <td>{{ $startIndex + $loop->index }}</td>
                <td style="max-width: 550px;">{{ $item->name }}</td>
                <td>{{ $item->merchCategory->name }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>
                    <a href="/admin/dashboard/merchandise/{{ $item->slug }}" class="btn-action-dashboard btn-sm me-2"><i
                            class="fas fa-eye"></i></a>

                    <a href="/admin/dashboard/merchandise/{{ $item->slug }}/edit"
                        class="btn-action-dashboard btn-sm me-2"><i class="fas fa-edit"></i></a>
                    <form action="/admin/dashboard/merchandise/{{ $item->slug }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn-action-dashboard btn-sm me-2"
                            onclick="return confirm ('Are you sure to delete this entry?')"><i
                                class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        <tbody>
    </table>
    {{ $merchandise->links() }}
</div>
@endsection