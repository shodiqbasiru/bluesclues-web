@extends('dashboard.layouts.main')
@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">

    {{-- dialog box --}}
    <dialog id="approve_confirmation" class="box-dialog" style="max-width: 500px; text-align: center;">
        <h5>Are you sure you want to accept this show request?</h5>
        <p>By accepting this show request, an email will be sent to the company notifying them that their request has
            been accepted. </p>
        <form method="POST" action="" id="approve_request">
            @csrf
            <label for="notes">Notes:</label>
            <div>
                <textarea id="notes" name="notes" rows="6" cols="40" style="resize: none;"></textarea>
            </div>
            <button type="submit" class="btn btn-md btn-outline-light me-2"><span>Yes</span></button>
            <button type="button" class="btn btn-md btn-outline-light me-2"
                onclick="approve_confirmation.close(); event.preventDefault();"><span>No</span></button>
        </form>
    </dialog>
    <dialog id="reject_confirmation" class="box-dialog" style="max-width: 500px; text-align: center;">
        <h5>Are you sure you want to reject this show request?</h5>
        <p>By rejecting this show request, an email will be sent to the company notifying them that their request has
            been rejected.</p>
        <form method="POST" action="" id="reject_request">
            @csrf
            <label for="notes">Notes:</label>
            <div>
                <textarea id="notes" name="notes" rows="6" cols="40" style="resize: none;"></textarea>
            </div>
            <button type="submit" class="btn btn-md btn-outline-light me-2"><span>Yes</span></button>
            <button type=" button" class="btn btn-md btn-outline-light me-2"
                onclick="reject_confirmation.close(); event.preventDefault();"><span>No</span></button>
        </form>
    </dialog>

    <dialog id="cancel_confirmation" class="box-dialog" style="max-width: 500px; text-align: center;">
        <h5>Are you sure you want to cancel this show request?</h5>
        <p>By cancelling this show request, the request will be marked as cancelled. This action will not send any
            email notifications.</p>

        <form method="POST" action="" id="cancel_request">
            @csrf
            <button type="submit" class="btn btn-md btn-outline-light me-2"><span>Yes</span></button>
            <button type=" button" class="btn btn-md btn-outline-light me-2"
                onclick="cancel_confirmation.close(); event.preventDefault();"><span>No</span></button>
        </form>
    </dialog>
    {{-- end dialog box --}}

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mt-5">
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                @if ($errors->has('error'))
                <div class="alert alert-danger alert-dismissible fade show my-2" role="alert">
                    {{ $errors->first('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <a href="{{ url()->previous() }}" class="btn btn-transparent me-2">
                    <div class="d-flex justify-content-center align-items-center"><span data-feather="arrow-left"
                            class="me-1"></span> Go back</div>
                </a>

                <h3 class="mb-3 mt-3">Show Request Details:</h3>
                <table class="table table-striped table-sm">
                    <tr>
                        <td><strong>Event Name:</strong></td>
                        <td>{{ $showRequest->eventname }}</td>
                    </tr>
                    <tr>
                        <td><strong>Company Name / Name:</strong></td>
                        <td>{{ $showRequest->company_name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ $showRequest->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Location:</strong></td>
                        <td>{{ $showRequest->location }}</td>
                    </tr>
                    <tr>
                        <td><strong>Date:</strong></td>
                        <td>{{ \Illuminate\Support\Carbon::parse($showRequest->date)->format('d F Y') }}</td>
                    </tr>
                    <tr>
                        <td><strong>WhatsApp:</strong></td>
                        <td>{{ $showRequest->whatsapp }}</td>
                    </tr>
                    <tr>
                        <td><strong>Status:</strong></td>
                        <td>
                            @if ($showRequest->status == 0)
                            <span class="badge bg-warning text-dark">Awaiting Approval</span>
                            @elseif ($showRequest->status == 1)
                            <span class="badge bg-success">Accepted</span>
                            @elseif ($showRequest->status == 2)
                            <span class="badge bg-danger">Rejected</span>
                            @elseif ($showRequest->status == 3)
                            <span class="badge bg-secondary">Cancelled</span>
                            @endif
                        </td>
                </table>


                @if ($showRequest->notes)
                <h4 class="mb-3 mt-5">Notes:</h4>
                <article class="mb-5">
                    <div style="overflow-wrap: break-word;">
                        {{ $showRequest->notes }}
                    </div>
                </article>
                @endif


                @if ($showRequest->status === 0)
                <div class="d-flex align-items-center justify-content-center">
                    <button type="button" class="btn btn-sm btn-success me-2 mb-5"
                        onclick="showConfirmationModal('approve', {{ $showRequest->id }})"><span>Accept</span></button>
                    <button type="button" class="btn btn-sm btn-danger me-2 mb-5"
                        onclick="showConfirmationModal('reject', {{ $showRequest->id }})"><span>Reject</span></button>
                    @endif

                    @if ($showRequest->status == 1)
                    <a href={{ route('show-request.add-to-event', ['showRequest'=> $showRequest->id]) }}
                        class="btn-primary-dashboard mb-3 me-2">
                        <i class="fas fa-circle-plus mb-5"></i> Add as an event</a>
                    <button type="button" class="btn-primary-dashboard mb-3" style="background-color: #ff4136"
                        onclick="showConfirmationModal('cancel', {{ $showRequest->id }})"><i
                            class="fas fa-circle-xmark"></i> Cancel</a></button>
                    @endif
                </div>
            </div>

        </div>

    </div>

    <script>
        function showConfirmationModal(action, id) {
                if (action === 'approve') {
                    const approveRequestButton = document.getElementById('approve_request');
                    approveRequestButton.action = '/show-requests/' + id + '/approve';
                    approve_confirmation.showModal();
                } else if (action === 'reject') {
                    const rejectRequestButton = document.getElementById('reject_request');
                    rejectRequestButton.action = '/show-requests/' + id + '/reject';
                    reject_confirmation.showModal();
                } else if (action === 'cancel') {
                    const cancelRequestButton = document.getElementById('cancel_request');
                    cancelRequestButton.action = '/show-requests/' + id + '/cancel';
                    cancel_confirmation.showModal();
                } 
            }
    </script>
    @endsection