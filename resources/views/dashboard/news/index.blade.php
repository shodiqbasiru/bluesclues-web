@extends('dashboard.layouts.main')
@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2">
        <div></div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <form action="{{ route('news.index') }}" method="GET">
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
                    <button type="submit" class="btn-primary-dashboard">Filter</button>
                </div>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center mb-3 border-bottom">
        <h1 class="h2">All News</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <form action="{{ route('news.index') }}" method="GET">
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
                            <option value="{{ $yearonly }}" {{ $yearonly == $selectedYearOnly ? 'selected' : '' }}>
                                {{ $yearonly }}
                            </option>
                        @endfor
                    </select>
                    <button type="submit" class="btn-primary-dashboard">Filter</button>
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

    <div class="table-responsive">
        <div class="d-flex justify-content-between">
            <a href="/admin/dashboard/news/create" class="btn-primary-dashboard mb-3">Create a news</a>
            <form action="{{ route('news.index') }}" method="GET" class="mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" placeholder="Search news"
                        value="{{ $searchQuery ?? '' }}">
                    <button type="submit" class="btn-primary-dashboard">Search</button>
                </div>
            </form>
        </div>
        @if ($searchQuery)
            <div class="mb-3">
                <h5>Showing results for: "{{ $searchQuery }}"</h5>
            </div>
        @endif

        @if ($month && $selectedYear)
            <div class="mb-3">
                <h5>Showing news created in: {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $selectedYear }}</h5>
            </div>
        @endif

        @if ($selectedYearOnly)
            <div class="mb-3">
                <h5>Showing news created in: {{ $selectedYearOnly }}</h5>
            </div>
        @endif
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Published at</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($news as $item)
                    <tr>
                        <td>{{ $startIndex + $loop->index }}</td>
                        <td style="max-width: 550px;">{{ $item->title }}</td>
                        <td>{{ $item->created_at->format('d F Y') }}</td>
                        <td>
                            <a href="/admin/dashboard/news/{{ $item->slug }}" class="btn-action-dashboard me-2"><i
                                    class="fas fa-eye"></i></a>

                            <a href="/admin/dashboard/news/{{ $item->slug }}/edit" class="btn-action-dashboard me-2"><i
                                    class="fas fa-edit"></i></a>
                            <form action="/admin/dashboard/news/{{ $item->slug }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn-action-dashboard me-2"
                                    onclick="return confirm ('Are you sure to delete this entry?')"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $news->links() }}
    </div>
@endsection
