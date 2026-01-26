@extends('layouts.app')
@section('content')
    <div class="container-lg px-4">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <a href="{{ route('journal.upload') }}" class="btn btn-sm btn-primary">+ Filter Baru</a>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Credit Facility</h5>
                        <div class="table-responsive mt-1">
                            <table class="table table-hover table-bordered" id="dataTables">
                                <thead class="table-primary">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No Akun</th>
                                    <th>No tiket</th>
                                    <th>Waktu</th>
                                    <th>Ip Address</th>
                                    <th>Credit In</th>
                                    <th>Credit Out</th>
                                    <th>Baris Log</th>
                                </thead>
                                <tbody>
                                    @foreach ($credit_facility as $cf)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ \Carbon\Carbon::parse($cf->tanggal)->format('Y-m-d') }}</td>
                                            <td>{{ $cf->no_akun }}</td>
                                            <td>{{ $cf->no_tiket }}</td>
                                            <td>{{ $cf->waktu }}</td>
                                            <td>{{ $cf->ip_address }}</td>
                                            <td>Rp. {{ $cf->credit_in }}</td>
                                            <td>Rp. {{ $cf->credit_out }}</td>
                                            <td>{{ $cf->raw_line }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
