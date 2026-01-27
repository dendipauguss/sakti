@extends('layouts.app')
@section('content')
    <section>
        <div class="row">
            <div class="col-md-6 mb-3">
                <a href="{{ route('journal.index') }}" class="btn btn-sm btn-success">Lihat Dashboard</a>
                <a href="{{ route('journal.pdf') }}" class="btn btn-sm btn-danger">Export PDF</a>
                <a href="" onclick="windows.history().back()" class="btn btn-sm btn-dark">Kembali</a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-4">Equity Report</h4>
                            @if (count($rows))
                                <div class="table-responsive">
                                    <table class="table table-bordered align-middle">
                                        <thead class="table-primary">
                                            <tr>
                                                <th>No</th>
                                                <th>No Akun</th>
                                                <th>Group</th>
                                                <th>Balance</th>
                                                <th>Credit</th>
                                                <th>Equity</th>
                                                <th>Margin</th>
                                                <th>Free Margin</th>
                                                <th>Tanggal Report</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($parsed_equity as $i => $line)
                                                <tr>
                                                    <td>{{ $i + 1 }}</td>
                                                    <td>{{ $line['no_akun'] }}</td>
                                                    <td>{{ $line['group'] }}</td>
                                                    <td>{{ $line['balance'] }}</td>
                                                    <td>{{ $line['credit'] }}</td>
                                                    <td>{{ $line['equity'] }}</td>
                                                    <td>{{ $line['margin'] }}</td>
                                                    <td>{{ $line['free_margin'] }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($line['report_date'])->format('Y-m-d') }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Tidak ada data credit facility ditemukan.</p>
                            @endif

                            <form method="POST" action="{{ route('journal.save.credit') }}">
                                @csrf
                                <button class="btn btn-primary btn-sm mb-2">
                                    💾 Simpan Credit Facility
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
