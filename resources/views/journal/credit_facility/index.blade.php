@extends('layouts.app')
@section('content')
    <div class="container-lg px-4">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Credit Facility</h5>
                        <table class="table table-hover table-bordered" id="dataTables">
                            <thead class="table-dark">
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
                                        <td>{{ $cf->credit_in }}</td>
                                        <td>{{ $cf->credit_out }}</td>
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
@endsection
