<!DOCTYPE html>
<html>

<head>
    <title>Show Requests Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 7pt;
        }

        .report-created {
            position: absolute;
            top: 5px;
            right: 5px;
            text-align: right;
            font-size: 6pt;
        }

        header .logo-report h1 {
            font-size: 24px;
        }
    </style>

    <header>
        <div class="logo-report">
            <h1>Blues Clues</h1>
        </div>
        <div class="report-created">
            @php
                $currentTime = \Carbon\Carbon::now('Asia/Jakarta')->format('F j, Y \a\t h:i A');
            @endphp
            <p>Report generated on {{ $currentTime }} (UTC+7)</p>
        </div>

    </header>
    <center>
        <h4>Show Request Report</h4>
    </center>

    <h5></h5>
    <div class="mb-3 mt-3">
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
            <h5>{{ $statusText }} Show Requests Report</h5>
        @endif

        @if ($month && $selectedYear)
            <h5> {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $selectedYear }}</h5>
        @endif

        @if ($selectedYearOnly)
            <h5> {{ $selectedYearOnly }}</h5>
        @endif

        @if (!$status && !$month && !$selectedYear && !$selectedYearOnly)
            <h5>All Show Requests</h5>
        @endif
    </div>

    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Company Name</th>
                <th scope="col">Email</th>
                <th scope="col">Date</th>
                <th scope="col">Event Name</th>
                <th scope="col">Location</th>
                <th scope="col">WhatsApp</th>
                <th scope="col">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($showRequests as $item)
                <tr class="align-middle">
                    <td class="align-middle">{{ $loop->iteration }}</td>
                    <td class="align-middle" style="max-width: 100px;">{{ $item->company_name }}</td>
                    <td class="align-middle">{{ $item->email }}</td>
                    <td class="align-middle">{{ \Illuminate\Support\Carbon::parse($item->date)->format('d F Y') }}</td>
                    <td class="align-middle" style="max-width: 100px;">{{ $item->eventname }}</td>
                    <td class="align-middle" style="max-width: 100px;">{{ $item->location }}</td>
                    <td class="align-middle">{{ $item->whatsapp }}</td>
                    <td class="align-middle">
                        @if ($item->status === 0)
                            <span class="badge badge-warning">Awaiting Approval</span>
                        @elseif ($item->status === 1)
                            <span class="badge badge-success">Approved</span>
                        @elseif ($item->status === 2)
                            <span class="badge badge-danger">Rejected</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">Data Empty</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
