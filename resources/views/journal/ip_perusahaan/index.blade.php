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
                                <thead class="table-primary">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>IP Address Publik</th>
                                    <th>IP Address Perusahaan</th>
                                    <th>Baris Log</th>
                                </thead>
                                <tbody>
                                    @foreach ($market_execution as $wem)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $wem->tanggal->format('Y-m-d') }}</td>
                                            <td>{{ $wem->waktu }}</td>
                                            <td>{{ $wem->ip_address_publik }}</td>
                                            <td>{{ $wem->ip_address_perusahaan }}</td>
                                            <td>{{ $wem->raw_line }}</td>
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
