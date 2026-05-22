<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Students</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { font-size: 16px; margin: 0 0 12px 0; }
        .meta { font-size: 11px; color: #555; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 6px; vertical-align: top; }
        th { background: #f5f5f5; text-align: left; }
    </style>
</head>
<body>
    <h1>Students</h1>
    <div class="meta">Generated at: {{ now()->format('Y-m-d H:i') }}</div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Degree</th>
                <th>Contact</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->degree?->name }}</td>
                    <td>{{ $student->contact_no }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
