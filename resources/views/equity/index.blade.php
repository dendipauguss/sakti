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
                        <h5 class="card-title">Equity Report</h5>
                        <div class="table-responsive mt-1">
                            <table class="table table-hover table-bordered" id="dataTables">
                                <thead class="table-dark">
                                    <th>No</th>
                                    <th>No Akun</th>
                                    <th>Group</th>
                                    <th>Balance</th>
                                    <th>Credit</th>
                                    <th>Equity</th>
                                    <th>Margin</th>
                                    <th>Free Margin</th>
                                    <th>Floating P/L</th>
                                    <th>Margin Level</th>
                                    <th>Risk Status</th>
                                    <th>Tanggal Report</th>
                                </thead>
                                <tbody>
                                    @foreach ($equity_report as $er)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $er->no_akun }}</td>
                                            <td>{{ $er->group }}</td>
                                            <td>{{ $er->balance }}</td>
                                            <td>{{ $er->credit }}</td>
                                            <td>{{ $er->equity }}</td>
                                            <td>{{ $er->margin }}</td>
                                            <td>{{ $er->free_margin }}</td>
                                            <td>{{ $er->floating_pl }}</td>
                                            <td>{{ $er->margin_level }}</td>
                                            <td>{{ $er->risk_status }}</td>
                                            <td>{{ \Carbon\Carbon::parse($er->tanggal)->format('Y-m-d') }}</td>
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
