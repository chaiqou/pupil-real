<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lunch Totals</title>
    <style>
        /* Add some basic styles to the table */
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Lunch Totals</h1>
    <table>
        <thead>
            <tr>
                <th>Lunch Name</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
