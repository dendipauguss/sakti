@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h3>Hasil Parsing Journal</h3>

        <a href="{{ route('journal.dashboard') }}" class="btn btn-success mb-3">Lihat Dashboard</a>
        <a href="" onclick="windows.history().back()">Kembali</a>
        <div class="card p-3">
            <h5>Jumlah baris: {{ count($parsed) }}</h5>

            <pre class="mt-3" style="background: #f7f7f7; padding: 10px; border-radius: 5px; max-height: 450px; overflow:auto;">
            @foreach ($parsed as $line)
{{ $line }}
@endforeach
            </pre>
        </div>

        <div class="row">
            <h4 class="mt-4">Credit Facility</h4>
            @if (count($creditFacility))
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Line</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($creditFacility as $i => $line)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        <pre class="m-0">{{ $line }}</pre>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Tidak ada data credit facility ditemukan.</p>
            @endif
        </div>
        <div class="row">
            <h4 class="mt-5">Waktu Eksekusi Market (Delay > 1 detik)</h4>

            @if (count($marketExecution))
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Request</th>
                                <th>Confirm</th>
                                <th>Delay (Detik)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($marketExecution as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        <pre class="m-0">{{ $row['request'] }}</pre>
                                    </td>
                                    <td>
                                        <pre class="m-0">{{ $row['confirm'] }}</pre>
                                    </td>
                                    <td class="text-danger fw-bold">{{ $row['delay_seconds'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Tidak ditemukan eksekusi market yang delay lebih dari 1 detik.</p>
            @endif

        </div>
        <div class="row">
            <h4 class="mt-5">Harga Tidak Sesuai</h4>

            @if (count($wrongPrice))
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Confirm</th>
                                <th>Close Order</th>
                                <th>Exec Type</th>
                                <th>Completed</th>
                                <th>Bid</th>
                                <th>Ask</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wrongPrice as $i => $row)
                                <tr>
                                    <td>{{ $i + 1 }}</td>

                                    <td>
                                        <pre class="m-0">{{ $row['confirm'] }}</pre>
                                    </td>
                                    <td>
                                        <pre class="m-0">{{ $row['close_order'] }}</pre>
                                    </td>

                                    <td class="fw-bold text-primary">
                                        {{ strtoupper($row['exec_type']) }}
                                    </td>

                                    <td class="fw-bold text-danger">{{ $row['completed'] }}</td>
                                    <td>{{ $row['bid'] }}</td>
                                    <td>{{ $row['ask'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted">Tidak ada harga tidak sesuai.</p>
            @endif

        </div>

    </div>
@endsection
