<!DOCTYPE html>
<html>

    <head>
        <title>Upload HTML</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>

    <body class="p-4">
        <div class="container">
            <h2>Upload File HTML</h2>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('upload.process') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Pilih file HTML</label>
                    <input type="file" name="file" accept=".html,.htm" class="form-control" required>
                </div>
                <button class="btn btn-primary">Upload & Parse</button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Dashboard</a>
            </form>
        </div>
    </body>

</html>
