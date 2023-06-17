<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Show Request</title>
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

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>New Show Request</h2>
        <p>A new show request has been made. Here are the details:</p>

        <table>
            <tr>
                <th>Company Name:</th>
                <td>{{ $companyName }}</td>
            </tr>
            <tr>
                <th>Email:</th>
                <td>{{ $email }}</td>
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

        <p>Please take appropriate action.</p>
    </div>
</body>
</html>
