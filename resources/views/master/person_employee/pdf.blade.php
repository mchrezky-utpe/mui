<!DOCTYPE html>
<html>
<head>
    <title>Person Employee PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>PERSON Employee List</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Full Name</th>
                <th>Jenis Kelamin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $value)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $value->firstname }}</td>
                    <td>{{ $value->middlename }}</td>
                    <td>{{ $value->lastname }}</td>
                    <td>{{ $value->fullname }}</td>
                    <td>{{ $value->flag_gender == 1 ? 'Laki-laki' : 'Perempuan' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
