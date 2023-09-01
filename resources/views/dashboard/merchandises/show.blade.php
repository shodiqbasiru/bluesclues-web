@extends('dashboard.layouts.main')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <div class="d-flex justify-content-center mt-5">
                    <a href="{{ url()->previous() }}" class="btn btn-transparent me-2 mb-2">
                        <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left"
                                class="me-1"></span> Back to Merchs</div>
                    </a>
                </div>
                <div class="d-flex justify-content-center">

                    <a href="/admin/dashboard/merchandise/{{ $merchandise->slug }}/edit" class="btn btn-outline-light me-2">
                        <div class="d-flex justify-content-center align-items-center"><span data-feather="edit"
                                class="me-1"></span>
                            Edit</div>
                    </a>
                    <form action="/admin/dashboard/merchandise/{{ $merchandise->slug }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-outline-light me-2">
                            <div class="d-flex justify-content-center align-items-center"
                                onclick="return confirm ('Are you sure to delete this entry?')"><span
                                    data-feather="trash" class="me-1"></span>
                                Delete</div>
                        </button>
                    </form>
                </div>

                @if ($merchandise->image)
                <div class="d-flex justify-content-center mt-5">
                    <img src="{{ asset('storage/' . $merchandise->image) }}" class="w-75" alt="image" class="img-fluid">
                </div>
                @endif
                <div class="mx-auto mt-3 text-center">
                    <h2 class=" mb-4">{{ $merchandise->name }}</h2>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center">
                                <h3><span class="badge bg-primary badge-lg">
                                    <strong>Category:</strong> {{ $merchandise->merchCategory->name }}
                                </span>
                                </h3>
                            </div>
                            <div class="text-center">
                                <h3><span class="badge bg-success badge-lg">
                                    <strong>Price:</strong> Rp {{ number_format($merchandise->price, 0, ',', '.') }}
                                </span>
                                </h3>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="text-center">
                                <h3><span class="badge bg-info badge-lg">
                                    <strong>Weight:</strong> {{ $merchandise->weight }} g
                                </span>
                                </h3>
                            </div>
                            <div class="text-center">
                                <h3><span class="badge bg-warning badge-lg">
                                    <strong>Stock:</strong> {{ $merchandise->stock }} pcs
                                </span>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>                
        
                
                <div class="card my-5">
                    <div class="card-body">
                        <h3 class="card-title mb-4">Descriptions:</h3>
                        <article class="mb-5">
                            {!! $merchandise->description !!}
                        </article>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection