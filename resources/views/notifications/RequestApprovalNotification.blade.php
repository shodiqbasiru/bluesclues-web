<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
    <style>
        /* Styles for the card */
        .card {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f8f8f8;
            text-align: center;
        }

        /* Styles for the table */
        table {
            margin-top: 20px;
            width: 100%;
        }

        th,
        td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .muted-text {
            color: #999999;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>{{ $subject }}</h2>
        <p>Hello {{ $companyName }},</p>
        <p>{{ $body }}</p>
        <p>Here are the details of the show request:</p>
        <table>
            <tr>
                <th>Company Name:</th>
                <td>{{ $companyName }}</td>
            </tr>
            <tr>
                <th>Date of show:</th>
                <td>{{ \Carbon\Carbon::parse($date)->format('j F Y') }}</td>
            </tr>
            <tr>
                <th>WhatsApp:</th>
                <td>{{ $whatsapp }}</td>
            </tr>
        </table>

        @if (!empty($notes) && $notes !== "")
            <p class="text-muted">Note: {{ $notes }}</p>
        @endif

        <p>{{ $bottom_text }}</p>


        <p> Best regards,</p>
        <p> Blues Clues</p>
    </div>
</body>

</html>