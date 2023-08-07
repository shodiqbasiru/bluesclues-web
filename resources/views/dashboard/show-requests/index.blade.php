@extends('dashboard.layouts.main')
@section('content')

<div class="d-flex justify-content-between py-3 flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
    <h1 class="h2">Show Requests</h1>

    <div class="btn-toolbar mb-2 mb-md-0">
        <form action="{{ route('show-requests.export') }}" method="GET">
            <div class="mx-2">
                @if ($status)
                <input type="hidden" name="status" value="{{ $status ?? '' }}">
                @endif
                @if ($month)
                <input type="hidden" name="month" value="{{ $month ?? '' }}">
                @endif
                @if ($selectedYear)
                <input type="hidden" name="year" value="{{ $selectedYear ?? '' }}">
                @endif
                @if ($selectedYearOnly)
                <input type="hidden" name="yearonly" value="{{ $selectedYearOnly ?? '' }}">
                @endif
                <button type="submit" class="btn-primary-dashboard">Export</button>
            </div>
        </form>

    </div>
</div>
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show my-2" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
<div class="d-flex justify-content-between">
    <form action="{{ route('show-requests.index', ['status' => $status ?? '']) }}" method="GET" class="me-3">
        <div class="btn-group" role="group" aria-label="Filter show requests">
            <button type="button" class="btn-primary-dashboard dropdown-toggle" data-bs-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                {{ $status ? ucfirst($status) : 'Filter By Status' }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <button type="submit" name="status" value="awaiting-approval"
                    class="dropdown-item{{ $status === 'awaiting-approval' ? ' active' : '' }}">Awaiting
                    Approval</button>
                <button type="submit" name="status" value="approved"
                    class="dropdown-item{{ $status === 'approved' ? ' active' : '' }}">Approved</button>
                <button type="submit" name="status" value="rejected"
                    class="dropdown-item{{ $status === 'rejected' ? ' active' : '' }}">Rejected</button>
            </div>
        </div>
    </form>

    <div class="filter-dashboard">
        <div class="dropdown mb-3">
            <button class="btn-filter-dashboard dropdown-toggle" type="button" id="filterDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                Select Filter Option
            </button>
            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                <li><a class="dropdown-item" href="#" data-filter="monthYear">Filter by Month and Year</a>
                </li>
                <li><a class="dropdown-item" href="#" data-filter="yearOnly">Filter by Year</a></li>
            </ul>
        </div>

        <div id="filterMonthYearForm" style="display: none;" class="mb-3">
            <form action="{{ route('show-requests.index') }}" method="GET">
                <div class="input-group">
                    <select class="form-select" name="month" required>
                        <option value="">Select Month</option>
                        @for ($i = 1; $i <= 12; $i++) <option value="{{ $i }}" {{ $month==$i ? 'selected' : '' }}>
                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                            </option>
                            @endfor
                    </select>
                    <select class="form-select" name="year" required>
                        <option value="">Select Year</option>
                        @php
                        $currentYear = date('Y');
                        $yearRange = 3;
                        $startYear = $currentYear - $yearRange;
                        $endYear = $currentYear + $yearRange;
                        @endphp
                        @for ($year = $startYear; $year <= $endYear; $year++) <option value="{{ $year }}" {{
                            $year==$selectedYear ? 'selected' : '' }}>
                            {{ $year }}
                            </option>
                            @endfor
                    </select>
                    <input type="hidden" name="status" value="{{ $status ?? '' }}">
                    <button type="submit" class="btn-filter-dashboard">Filter</button>
                </div>
            </form>
        </div>

        <div id="filterYearOnlyForm" style="display: none;" class="mb-3">
            <form action="{{ route('show-requests.index') }}" method="GET">
                <div class="input-group">
                    <select class="form-select" name="yearonly" required>
                        <option value="">Select Year</option>
                        @php
                        $currentYear = date('Y');
                        $yearRange = 3;
                        $startYear = $currentYear - $yearRange;
                        $endYear = $currentYear + $yearRange;
                        @endphp
                        @for ($yearonly = $startYear; $yearonly <= $endYear; $yearonly++) <option
                            value="{{ $yearonly }}" {{ $yearonly==$selectedYearOnly ? 'selected' : '' }}>
                            {{ $yearonly }}
                            </option>
                            @endfor
                    </select>
                    <input type="hidden" name="status" value="{{ $status ?? '' }}">
                    <button type="submit" class="btn-filter-dashboard">Filter</button>
                </div>
            </form>
        </div>

    </div>

    <form action="{{ route('show-requests.index') }}" method="GET" class="mb-3 ms-auto">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search requests"
                value="{{ $searchQuery ?? '' }}">
            <button type="submit" class="btn-filter-dashboard"><i class="fas fa-search"></i></button>
        </div>
    </form>
</div>

<div class="table-responsive">
    <dialog id="approve_confirmation" class="box-dialog" style="max-width: 500px; text-align: center;">
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



    @if ($searchQuery)
    <div class="mb-3">
        @if ($status)
        @php
        $statusText = '';
        if ($status === 'awaiting-approval') {
        $statusText = 'Awaiting Approval';
        } elseif ($status === 'approved') {
        $statusText = 'Approved';
        } elseif ($status === 'rejected') {
        $statusText = 'Rejected';
        }
        @endphp
        @endif

        @if ($searchQuery)
        <h5>Search results for: "{{ $searchQuery }}"</h5>
        @endif
    </div>
    @endif

    @if ($month && $selectedYear)
    <div class="mb-3">
        @if ($status)
        @php
        $statusText = '';
        if ($status === 'awaiting-approval') {
        $statusText = 'awaiting approval';
        } elseif ($status === 'approved') {
        $statusText = 'approved';
        } elseif ($status === 'rejected') {
        $statusText = 'rejected';
        }
        @endphp
        @endif
        <h5>Showing {{ $statusText }} show requests for: {{ date('F', mktime(0, 0, 0, $month, 1)) }}
            {{ $selectedYear }}</h5>
    </div>
    @endif

    @if ($selectedYearOnly)
    <div class="mb-3">
        @if ($status)
        @php
        $statusText = '';
        if ($status === 'awaiting-approval') {
        $statusText = 'awaiting approval';
        } elseif ($status === 'approved') {
        $statusText = 'approved';
        } elseif ($status === 'rejected') {
        $statusText = 'rejected';
        }
        @endphp
        @endif
        <h5>Showing {{ $statusText }} show requests for: {{ $selectedYearOnly }}</h5>
    </div>
    @endif

    <table class="table table-sm">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Company Name</th>
                <th scope="col">Email</th>
                <th scope="col">Date</th>
                <th scope="col">Event Name</th>
                <th scope="col">Location</th>
                <th scope="col">WhatsApp</th>
                @if ($status === NULL)
                <th scope="col">Notes/Decision</th>
                @elseif ($status === 'awaiting-approval')
                <th scope="col">Decision</th>
                @else
                <th scope="col">Notes</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($showRequests as $item)
            <tr class="align-middle">
                <td class="align-middle">{{ $startIndex + $loop->index }}</td>
                <td class="align-middle" style="max-width: 100px;">{{ $item->company_name }}</td>
                <td class="align-middle">{{ $item->email }}</td>
                <td class="align-middle">{{ \Illuminate\Support\Carbon::parse($item->date)->format('d F Y') }}
                </td>
                <td class="align-middle" style="max-width: 100px;">{{ $item->eventname }}</td>
                <td class="align-middle" style="max-width: 100px;">{{ $item->location }}</td>
                <td class="align-middle">{{ $item->whatsapp }}</td>
                
                @if ($item->status == 0)
                <td>
                    <button type="button" class="btn btn-sm btn-success me-2"
                        onclick="showConfirmationModal('approve', {{ $item->id }})"><span>Approve</span></button>
                    <button type="button" class="btn btn-sm btn-danger me-2"
                        onclick="showConfirmationModal('reject', {{ $item->id }})"><span>Reject</span></button>
                </td>
                @else
                <td style="max-width: 100px;">{{ $item->notes }}</td>
                @endif
                
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $showRequests->links() }}
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