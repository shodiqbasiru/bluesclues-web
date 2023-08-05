@extends('dashboard.layouts.main')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom py-3">
        <h1 class="h2">Messages</h1>
    </div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show my-2" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive">
        <div class="d-flex justify-content-between">
            <div>
                <div class="dropdown mb-3">
                    <button class="btn-primary-dashboard dropdown-toggle" type="button" id="filterDropdown"
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
                    <form action="/admin/dashboard/messages" method="GET">
                        <div class="input-group">
                            <span class="input-group-text">
                                <span data-feather="calendar" class="align-text-bottom"></span>
                            </span>
                            <select class="form-select" name="month" required>
                                <option value="">Select Month</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
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
                                @for ($year = $startYear; $year <= $endYear; $year++)
                                    <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                            <button type="submit" class="btn btn-outline-secondary">Filter</button>
                        </div>
                    </form>
                </div>

                <div id="filterYearOnlyForm" style="display: none;" class="mb-3">
                    <form action="/admin/dashboard/messages" method="GET">
                        <div class="input-group">
                            <span class="input-group-text">
                                <span class="align-text-bottom mx-2">Filter by year</span>
                                <span data-feather="calendar" class="align-text-bottom"></span>
                            </span>
                            <select class="form-select" name="yearonly" required>
                                <option value="">Select Year</option>
                                @php
                                    $currentYear = date('Y');
                                    $yearRange = 3;
                                    $startYear = $currentYear - $yearRange;
                                    $endYear = $currentYear + $yearRange;
                                @endphp
                                @for ($yearonly = $startYear; $yearonly <= $endYear; $yearonly++)
                                    <option value="{{ $yearonly }}"
                                        {{ $yearonly == $selectedYearOnly ? 'selected' : '' }}>
                                        {{ $yearonly }}
                                    </option>
                                @endfor
                            </select>
                            <button type="submit" class="btn btn-outline-secondary">Filter</button>
                        </div>
                    </form>
                </div>

            </div>

            <form action="/admin/dashboard/messages" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search messages"
                        value="{{ $searchQuery ?? '' }}">
                    <button type="submit" class="btn-filter-dashboard"><i class="fas fa-search"></i></button>
                </div>
            </form>
        </div>
        @if ($searchQuery)
            <div class="mb-3">
                <h5>Results for: "{{ $searchQuery }}"</h5>
            </div>
        @endif

        @if ($month && $selectedYear)
            <div class="mb-3">
                <h5>Showing messages created in: {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $selectedYear }}</h5>
            </div>
        @endif

        @if ($selectedYearOnly)
            <div class="mb-3">
                <h5>Showing messages created in: {{ $selectedYearOnly }}</h5>
            </div>
        @endif


        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Subject</th>
                    <th scope="col">WhatsApp</th>
                    <th scope="col">Created at</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($message as $item)
                    <tr>
                        <td class="align-middle">{{ $startIndex + $loop->index }}</td>
                        <td style="max-width: 100px; " class="align-middle">{{ $item->name }}</td>
                        <td class="align-middle">{{ $item->email }}</td>
                        <td style="max-width: 100px;" class="align-middle">{{ $item->subject }}</td>
                        <td class="align-middle">{{ $item->whatsapp }}</td>
                        <td class="align-middle">
                            {{ \Illuminate\Support\Carbon::parse($item->created_at)->format('d F Y') }}</td>
                        <td class="align-middle">
                            <a href="/admin/dashboard/messages/{{ $item->id }}"
                                class="btn-action-dashboard btn-sm me-2"><i class="fas fa-eye"></i></a>
                            <form action="/admin/dashboard/messages/{{ $item->id }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn-action-dashboard btn-sm me-2"
                                    onclick="return confirm ('Are you sure to delete this message?')"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            <tbody>
        </table>
        {{ $message->links() }}
    </div>
@endsection
