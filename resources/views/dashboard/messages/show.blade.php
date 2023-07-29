@extends('dashboard.layouts.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                <a href="/admin/dashboard/messages" class="btn btn-transparent me-2">
                    <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left"
                            class="me-1"></span> Back to message</div>
                </a>
                <h1>{{ $message->subject }}</h1>
                <div class="my-3">

                    <form action="/admin/dashboard/messages/{{ $message->id }}" method="post" class="d-inline">
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
                <p>
                    <small class="text-muted">
                        Sent: {{ $message->created_at->diffForHumans() }}
                    </small>
                </p>
                <h4>Message Details:</h4>
                <table class="table table-striped table-sm">
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $message->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td>{{ $message->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>WhatsApp:</strong></td>
                        <td>{{ $message->whatsapp }}</td>
                    </tr>
                </table>


                <h4>Message Content:</h4>
                <article class="mb-5">
                    <div style="overflow-wrap: break-word;">
                        {{ $message->message_content }}
                    </div>
                </article>
            </div>

        </div>

    </div>
    @endsection