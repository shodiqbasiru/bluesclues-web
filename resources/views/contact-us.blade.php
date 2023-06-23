@extends('layouts.main')

@section('content-page')
    <div class="container form" id="contact">
        <form class="row g-3" method="POST">
            @csrf
            <div class="col-12">
                <label for="name" class="form-label">Name*</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Please enter your name"
                    required>
            </div>
            <div class="col-12">
                <label for="email" class="form-label">Your E-mail*</label>
                <input type="email" name="email" class="form-control" id="email"
                    placeholder="Please enter your E-mail" required>
            </div>
            <div class="col-12">
                <label for="message" class="form-label">Message*</label>
                <textarea name="message" class="form-control" id="message" placeholder="Please enter your message" rows="3"
                    required></textarea>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-home">Sumbit</button>
            </div>
        </form>
    </div>
@endsection
