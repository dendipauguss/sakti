<!DOCTYPE html>
<html>

    <head>
        <title>Dashboard Klasifikasi</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body class="p-4">
        <div class="container">
            <h3>Dashboard Hasil Klasifikasi</h3>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="mb-3 d-flex gap-2">
                <a href="{{ route('upload.page') }}" class="btn btn-primary">Upload HTML</a>
                <a href="{{ route('export.excel') }}" class="btn btn-outline-success">Export Excel</a>
                <a href="{{ route('export.pdf') }}" class="btn btn-outline-danger">Export PDF</a>
            </div>

            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-3">
                    <select name="category" class="form-control">
                        <option value="">-- Semua Kategori --</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c }}" @if (request('category') == $c) selected @endif>
                                {{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control"
                        placeholder="Cari konten...">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-secondary">Filter</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-link">Reset</a>
                </div>
            </form>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Konten</th>
                        <th>Kategori</th>
                        <th>File</th>
                        <th>Tgl</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $i)
                        <tr>
                            <td>{{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}</td>
                            <td style="max-width:600px; white-space:normal;">{{ $i->content }}</td>
                            <td>{{ $i->category }}</td>
                            <td>{{ optional($i->file)->original_name }}</td>
                            <td>{{ $i->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{ $items->links() }}
        </div>
    </body>

</html>
