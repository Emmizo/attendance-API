<!DOCTYPE html>
<html>

<head>
    <title>Attendance Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        h1 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h1>Employee attendance</h1>
    <table>
        <thead>
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Identity</th>
                <th>Phone</th>
                <th>Entry</th>
                <th>Exit</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($list as $attendance)
                <tr>
                    <td>{{ $attendance->f_name }}</td>
                    <td>{{ $attendance->l_name }}</td>
                    <td>{{ $attendance->email }}</td>
                    <td>{{ $attendance->employee_identifier }}</td>
                    <td>{{ $attendance->phone_number }}</td>
                    <td>{{ $attendance->started_at }}</td>
                    <td>{{ $attendance->ended_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
