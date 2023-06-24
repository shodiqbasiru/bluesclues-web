<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
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
        <h2>Subject: {{ $message_subject }}</h2>
        <p>Details:</p>
        <table>
            <tr>
                <th>Name:</th>
                <td>{{ $name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $email }}</td>
            </tr>

        </table>

        <p>Message:</p>
        <p>{{ $message_content }}</p>
    </div>
</body>

</html>