<!DOCTYPE html>
<html>

    <head>
        <title>Preview Parsing</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            td {
                vertical-align: top;
            }
        </style>
    </head>

    <body class="p-4">
        <div class="container">
            <h3>Preview hasil parsing: {{ $file->original_name ?? $file->filename }}</h3>

            <form action="{{ route('save.classified', $file->id) }}" method="POST">
                @csrf
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Konten</th>
                            <th>Kategori (otomatis)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $no=1; @endphp
                        @foreach ($data as $d)
                            <tr>
                                <td style="width:50px">{{ $no++ }}</td>
                                <td>{{ $d }}</td>
                                <td>{{ app('App\Http\Controllers\FileController')->classify($d) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <input type="hidden" name="data" value="{{ json_encode($data) }}">
                <button class="btn btn-success">Simpan ke Database</button>
                <a href="{{ route('upload.page') }}" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </body>

</html>
