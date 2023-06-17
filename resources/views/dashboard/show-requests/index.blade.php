@extends('dashboard.layouts.main')
@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Show Requests</h1>
</div>
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show my-2" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="table-responsive">
    <dialog id="approve_confirmation" style="max-width: 500px; text-align: center;">
        <h5>Are you sure you want to approve this show request?</h5>
        <p>By approving this show request, an email will be sent to the company notifying them that their request has
            been approved. </p>
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
    <dialog id="reject_confirmation" style="max-width: 500px; text-align: center;">
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


    <form action="{{ route('show-requests.index', ['status' => $status ?? '']) }}" method="GET">
        <div class="btn-group" role="group" aria-label="Filter show requests">
            <button type="submit" name="status" value="awaiting-approval"
                class="btn btn-outline-light mb-3{{ $status === 'awaiting-approval' ? ' active' : '' }}">Awaiting
                Approval</button>
            <button type="submit" name="status" value="approved"
                class="btn btn-outline-light mb-3{{ $status === 'approved' ? ' active' : '' }}">Approved</button>
            <button type="submit" name="status" value="rejected"
                class="btn btn-outline-light mb-3{{ $status === 'rejected' ? ' active' : '' }}">Rejected</button>
        </div>
    </form>

    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Company Name</th>
                <th scope="col">Email</th>
                <th scope="col">Date</th>
                <th scope="col">WhatsApp</th>
                @if ($status !== 'approved' && $status !== 'rejected')
                <th scope="col">Decision</th>
                @else
                <th scope="col">Notes</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($showRequests as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td style="max-width: 550px;">{{ $item->company_name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ \Illuminate\Support\Carbon::parse($item->date)->format('d F Y') }}</td>
                <td>{{ $item->whatsapp }}</td>
                @if ($status !== 'approved' && $status !== 'rejected')
                <td>
                    <button type="button" class="btn btn-sm btn-outline-light me-2"
                        onclick="showConfirmationModal('approve', {{ $item->id }})"><span>Approve</span></button>
                    <button type="button" class="btn btn-sm btn-outline-light me-2"
                        onclick="showConfirmationModal('reject', {{ $item->id }})"><span>Reject</span></button>
                </td>
                @else
                <td style="max-width: 100px;">{{ $item->notes }}</td>
                @endif
            </tr>
            @endforeach
            {{ $showRequests->links() }}
        <tbody>
    </table>
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
    }
}


</script>
@endsection