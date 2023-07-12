<!DOCTYPE html>
<html>

<head>
    <title>Events Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }

        .report-created {
            position: absolute;
            top: 5px;
            right: 5px;
            text-align: right;
            font-size: 6pt;
        }
    </style>

    <div class="report-created">
        @php
            $currentTime = \Carbon\Carbon::now('Asia/Jakarta')->format('F j, Y \a\t h:i A');
        @endphp
        <p>Report generated on {{ $currentTime }} (UTC+7)</p>
    </div>

    <center>
        <div class="mb-2">
            <h1>Blues Clues</h1>
        </div>
        <h5>Events</h4>
    </center>

    <div class="mb-3 mt-3">
        @if ($month && $selectedYear)
            <h5> {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $selectedYear }}</h5>
        @elseif ($selectedYearOnly)
            <h5> {{ $selectedYearOnly }}</h5>
        @else
            <h5>Report events</h5>
        @endif
    </div>

    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Event Name</th>
                <th scope="col">Location</th>
                <th scope="col">Time</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($events as $item)
                <tr>
                    <td class="align-middle">{{ $loop->iteration }}</td>
                    <td class="align-middle" style="max-width: 300px;">{{ $item->eventname }}</td>
                    <td class="align-middle" style="max-width: 400px;">{{ $item->location }}</td>
                    <td class="align-middle">{{ $item->time }}</td>
                    <td class="align-middle">{{ \Illuminate\Support\Carbon::parse($item->date)->format('d F Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Data Empty</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
