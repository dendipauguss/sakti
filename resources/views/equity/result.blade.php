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
                    <a href="" onclick="event.preventDefault();document.getElementById('simpan-semua').submit();"
                        title="Simpan Semua" class="btn btn-sm btn-success">
                        <svg class="icon me-2">
                            <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-library">
                            </use>
                        </svg>
                        Simpan Semua</a>
                </div>
                <form id="simpan-semua" action="{{ route('journal.save.all') }}" method="POST">@csrf</form>
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
                                            <th>Equity File 1</th>
                                            <th>Equity File 2</th>
                                            <th>Selisih</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($comparison as $row => $data)
                                            <tr class="{{ $data['status'] == 'SAMA' ? 'table-danger' : '' }}">
                                                <td>{{ $row + 1 }}</td>
                                                <td>{{ $data['login'] }}</td>
                                                <td>{{ $data['name'] }}</td>
                                                <td>{{ $data['equity_file1'] !== null ? number_format($data['equity_file1'], 2) : '-' }}
                                                </td>
                                                <td>{{ $data['equity_file2'] !== null ? number_format($data['equity_file2'], 2) : '-' }}
                                                </td>
                                                <td>{{ number_format($data['selisih'], 2) }}</td>
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
