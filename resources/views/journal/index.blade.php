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
                        <h5 class="card-title">Credit Facility</h5>
                        <div class="table-responsive mt-1">
                            <table class="table table-hover table-bordered" id="dataTables">
                                <thead class="table-primary">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No Akun</th>
                                    <th>Jumlah</th>
                                    <th>Tipe</th>
                                    <th>Baris Credit In/Out</th>
                                </thead>
                                <tbody>
                                    @foreach ($credit_facility as $cf)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $cf->tanggal->format('Y-m-d') }}</td>
                                            <td>{{ $cf->no_akun }}</td>
                                            <td>{{ $cf->amount }}</td>
                                            <td>{{ $cf->type }}</td>
                                            <td>{{ $cf->raw_line }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <h5 class="card-title">Waktu Eksekusi Market</h5>
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

                        <h5 class="card-title">Harga Tidak Sesuai</h5>
                        <div class="table-responsive mt-1">
                            <table class="table table-hover table-bordered" id="dataTables">
                                <thead class="table-primary">
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>No Akun</th>
                                    <th>Tiket</th>
                                    <th>Tipe Eksekusi</th>
                                    <th>Harga Completed</th>
                                    <th>Harga Bid</th>
                                    <th>Harga Ask</th>
                                    <th>Baris Confirm</th>
                                    <th>Baris Close Order</th>
                                </thead>
                                <tbody>
                                    @foreach ($harga_tidak_sesuai as $hts)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $hts->tanggal }}</td>
                                            <td>{{ $hts->no_akun }}</td>
                                            <td>{{ $hts->no_tiket }}</td>
                                            <td>{{ $hts->exec_type }}</td>
                                            <td>{{ $hts->completed_price }}</td>
                                            <td>{{ $hts->bid_price }}</td>
                                            <td>{{ $hts->ask_price }}</td>
                                            <td>{{ $hts->confirm_raw }}</td>
                                            <td>{{ $hts->close_order_raw }}</td>
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
