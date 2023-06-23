@extends('layouts.main')

@section('content-page')
    <div class="container form" id="requestShow">
        <form class="row g-3" method="POST">
            @csrf
            <div class="col-md-6">
                <label for="name" class="form-label">Name/Company name*</label>
                <input type="teks" name="name" class="form-control" id="name" required autofocus>
            </div>
            <div class="col-md-6">
                <label for="eventName" class="form-label">Event name*</label>
                <input type="teks" name="eventName" class="form-control" id="eventName" required>
            </div>
            <div class="col-md-6">
                <label for="duration" class="form-label">Duration*</label>
                <input type="teks" name="duration" class="form-control" id="duration" required>
            </div>
            <div class="col-md-6">
                <label for="date" class="form-label">Date*</label>
                <input type="date" name="date" class="form-control" id="date" required>
            </div>
            <div class="col-12">
                <label for="location" class="form-label">Location*</label>
                <input type="text" name="location" class="form-control" id="location" required>
            </div>
            <div class="col-12">
                <label for="whatsapp" class="form-label">Whatsapp*</label>
                <input type="text" name="whatsapp" class="form-control" id="whatsapp" required>
            </div>
            <div class="col-12">
                <label for="email" class="form-label">Email*</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-home">Submit</button>
            </div>
        </form>
    </div>
@endsection
