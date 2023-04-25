@extends('dashboard.layouts.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <a href="/admin/dashboard/news" class="btn btn-transparent me-2">
                    <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left" class="me-1"></span> Back to News</div>
                </a>
                <h1>{{ $news->title }}</h1>
                <div class="my-3">
                    <a href="/admin/dashboard/news/{{ $news->slug }}/edit" class="btn btn-outline-light me-2">
                        <div class="d-flex justify-content-center align-items-center"><span data-feather="edit" class="me-1"></span>
                            Edit</div>
                    </a>
                    <form action="/admin/dashboard/news/{{ $news->slug }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="btn btn-outline-light me-2">
                            <div class="d-flex justify-content-center align-items-center" onclick="return confirm ('Are you sure to delete this entry?')"><span
                                    data-feather="trash" class="me-1"></span>
                                Delete</div>
                        </button>
                    </form>

                </div>
                <p>
                    <small class="text-muted">
                        Created: {{ $news->created_at->diffForHumans() }}
                    </small>
                </p>
                <p>
                    <small class="text-muted">
                        Last updated: {{ $news->updated_at->diffForHumans() }}
                    </small>
                </p>
                <img src="https://source.unsplash.com/1200x400?music " alt="image" class="img-fluid">

                <article class="mb-5 mt-5">
                    {!! $news->content !!}
                </article>
            </div>

        </div>

    </div>
    @endsection