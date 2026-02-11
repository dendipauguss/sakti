@extends('layouts.app')
@section('content')
    <div class="container-lg px-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="btn-group">
                    <a href="{{ route('equity.upload') }}" class="btn btn-sm btn-secondary">
                        <svg class="icon me-2">
                            <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-arrow-left">
                            </use>
                        </svg>
                        Kembali</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-4">Equity Report</h4>
                            @if (count($comparison) > 0)
                                <table class="table table-bordered align-middle" id="dataTables">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>No</th>
                                            <th>No Akun (Login)</th>
                                            <th>Nama</th>
                                            <th>Deposit 1</th>
                                            <th>Deposit 2</th>
                                            <th>Credit 1</th>
                                            <th>Credit 2</th>
                                            <th>Equity 1</th>
                                            <th>Equity 2</th>
                                            <th>Floating PL 1</th>
                                            <th>Floating PL 2</th>
                                            <th>Selisih Nilai Equity</th>
                                            <th>Satuan</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comparison as $row => $data)
                                            <tr class="{{ $data['status'] == 'SAMA' ? 'table-danger' : '' }}">
                                                <td>{{ $row + 1 }}</td>
                                                <td>{{ $data['login'] }}</td>
                                                <td>{{ $data['name'] }}</td>
                                                <td>{{ $data['deposit_1'] !== null ? number_format($data['deposit_1'], 2) : '-' }}
                                                </td>
                                                <td>{{ $data['deposit_2'] !== null ? number_format($data['deposit_2'], 2) : '-' }}
                                                </td>
                                                <td>{{ $data['credit_1'] !== null ? number_format($data['credit_1'], 2) : '-' }}
                                                </td>
                                                <td>{{ $data['credit_2'] !== null ? number_format($data['credit_2'], 2) : '-' }}
                                                </td>
                                                <td>{{ $data['equity_1'] !== null ? number_format($data['equity_1'], 2) : '-' }}
                                                </td>
                                                <td>{{ $data['equity_2'] !== null ? number_format($data['equity_2'], 2) : '-' }}
                                                </td>
                                                <td>{{ $data['floating_pl1'] !== null ? number_format($data['floating_pl1'], 2) : '-' }}
                                                </td>
                                                <td>{{ $data['floating_pl2'] !== null ? number_format($data['floating_pl2'], 2) : '-' }}
                                                </td>
                                                <td>{{ number_format($data['selisih'], 2) }}</td>
                                                <td>{{ $data['currency'] }}</td>
                                                <td>
                                                    @if ($data['status'] == 'NAIK')
                                                        <span class="badge bg-info">
                                                            <svg class="icon">
                                                                <use
                                                                    xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-arrow-top">
                                                                </use>
                                                            </svg>
                                                        </span> / <span class="badge bg-success">
                                                            <svg class="icon">
                                                                <use
                                                                    xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-check">
                                                                </use>
                                                            </svg>
                                                        </span>
                                                    @elseif ($data['status'] == 'TURUN')
                                                        <span class="badge bg-info">
                                                            <svg class="icon">
                                                                <use
                                                                    xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-arrow-bottom">
                                                                </use>
                                                            </svg></span> /
                                                        <span class="badge bg-success">
                                                            <svg class="icon">
                                                                <use
                                                                    xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-check">
                                                                </use>
                                                            </svg></span>
                                                    @elseif ($data['status'] == 'SAMA')
                                                        <span class="badge bg-warning">
                                                            <svg class="icon">
                                                                <use
                                                                    xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-media-pause">
                                                                </use>
                                                            </svg></span> /
                                                        <span class="badge bg-danger">
                                                            <svg class="icon">
                                                                <use
                                                                    xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-x">
                                                                </use>
                                                            </svg></span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ $data['status'] }}</span>
                                                    @endif
                                                </td>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p class="text-muted">Tidak ada data perbandingan yang ditemukan.</p>
                            @endif

                            <form method="POST" action="{{ route('equity.save.compare') }}">
                                @csrf
                                <button class="btn btn-primary btn-sm mb-2">
                                    💾 Simpan Perbandingan Equity Report
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
