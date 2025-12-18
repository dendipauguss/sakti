@extends('layouts.app')
@section('content')
    <section>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <a href="{{ route('journal.upload') }}" class="btn btn-sm btn-primary">+ Filter Baru</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive mt-1">
                            <table class="table table-hover table-bordered" id="dataTables">
                                <thead class="table-primary">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No Akun</th>
                                    <th>Tiket</th>
                                    <th>Baris Request</th>
                                    <th>Baris Confirm</th>
                                    <th>Selisih Waktu</th>
                                </thead>
                                <tbody>
                                    @foreach ($waktu_eksekusi_market as $wem)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $wem->tanggal->format('Y-m-d') }}</td>
                                            <td>{{ $wem->no_akun }}</td>
                                            <td>{{ $wem->no_tiket }}</td>
                                            <td>{{ $wem->request_raw }}</td>
                                            <td>{{ $wem->confirm_raw }}</td>
                                            <td>{{ $wem->delay_formatted }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
