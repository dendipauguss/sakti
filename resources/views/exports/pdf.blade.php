<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8" />
        <title>Export PDF</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                border: 1px solid #444;
                padding: 6px;
                font-size: 12px;
            }
        </style>
    </head>

    <body>
        <h3>Data Klasifikasi</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Konten</th>
                    <th>Kategori</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $d)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $d->content }}</td>
                        <td>{{ $d->category }}</td>
                        <td>{{ $d->created_at->format('Y-m-d') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>

</html>
