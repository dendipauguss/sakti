@extends('layouts.app')
@section('content')
    <div class="container-lg px-4">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <a href="{{ route('equity.upload') }}" class="btn btn-sm btn-primary">+ Filter Baru</a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Equity Comparisons</h5>
                        <table class="table table-hover table-bordered" id="dataTables">
                            <thead class="table-dark">
                                <th>No</th>
                                <th>File 1</th>
                                <th>File 2</th>
                                <th>Periode 1</th>
                                <th>Periode 2</th>
                                <th>Detail</th>
                            </thead>
                            <tbody>
                                @foreach ($equity_report as $er)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $er->file_1_name }}</td>
                                        <td>{{ $er->file_2_name }}</td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y.m.d', $er->periode_1)->format('Y-m-d') }}
                                        </td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y.m.d', $er->periode_2)->format('Y-m-d') }}
                                        </td>
                                        <td>
                                            <a href="{{ route('equity.show', $er->id) }}" class="btn btn-sm btn-info">Lihat
                                                Hasil</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
