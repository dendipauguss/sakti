@extends('layouts.app')
@section('content')
    <div class="container-lg px-4">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">IP Address Perusahaan</h5>
                        <div class="table-responsive mt-1">
                            <table class="table table-hover table-bordered" id="dataTables">
                                <thead class="table-dark">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>IP Address Publik</th>
                                    <th>IP Address Perusahaan</th>
                                    <th>Baris Log</th>
                                </thead>
                                <tbody>
                                    @foreach ($ip_perusahaan as $ip)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ip->tanggal->format('Y-m-d') }}</td>
                                            <td>{{ $ip->waktu }}</td>
                                            <td>{{ $ip->ip_address_publik }}</td>
                                            <td>{{ $ip->ip_address_perusahaan }}</td>
                                            <td>{{ $ip->raw_line }}</td>
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
