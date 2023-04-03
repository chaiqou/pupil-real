<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lunch Totals</title>
</head>
<body>
    <h1>Lunch Totals</h1>
    <table>
        <tbody>
            @foreach($lunches as $lunch)
            <tr>
                <th>Lunch Name: {{ $lunch['title'] }}</th>
                <th>Total {{ $totalOrders }}</th>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
