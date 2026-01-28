@extends('layouts.app')
@section('content')
    <div class="container-lg px-4">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card">
                    {{-- <div class="card-header">
                        <a href="{{ route('journal.upload') }}" class="btn btn-sm btn-primary">+ Filter Baru</a>
                    </div> --}}
                    <div class="card-body">
                        <h5 class="card-title">Harga Tidak Sesuai</h5>
                        <div class="table-responsive mt-1">
                            <table class="table table-hover table-sm table-striped border" id="dataTables">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Akun</th>
                                        <th>Tiket</th>
                                        <th>Tipe</th>
                                        <th>Completed</th>
                                        <th>Bid</th>
                                        <th>Ask</th>
                                        <th>Baris Confirm</th>
                                        <th>Baris Close Order</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($harga_tidak_sesuai as $hts)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td><small>{{ $hts->tanggal }}</small></td>
                                            <td>{{ $hts->no_akun }}</td>
                                            <td><code>{{ $hts->no_tiket }}</code></td>
                                            <td>
                                                <span
                                                    class="badge {{ $hts->exec_type == 'buy' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ strtoupper($hts->exec_type) }}
                                                </span>
                                            </td>
                                            <td class="fw-bold">{{ number_format($hts->completed_price, 5) }}</td>
                                            <td>{{ number_format($hts->bid_price, 5) }}</td>
                                            <td>{{ number_format($hts->ask_price, 5) }}</td>
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
    </div>
@endsection
