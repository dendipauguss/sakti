@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3>Hasil Parsing Journal</h3>

        <a href="{{ route('journal.dashboard') }}" class="btn btn-success mb-3">Lihat Dashboard</a>

        <div class="card p-3">
            <h5>Jumlah baris: {{ count($parsed) }}</h5>

            <pre class="mt-3" style="background: #f7f7f7; padding: 10px; border-radius: 5px; max-height: 450px; overflow:auto;">
@foreach ($parsed as $line)
{{ $line }}
@endforeach
        </pre>
        </div>
    </div>
@endsection
