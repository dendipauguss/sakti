@extends('layouts.app')
@section('content')
    <div class="container-lg">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="btn-group">
                    <a href="{{ route('journal.upload') }}" class="btn btn-sm btn-secondary">
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
                <h5>Jumlah baris: {{ $parsed }}</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">

                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Hasil Pencarian IP Perusahaan</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>IP Perusahaan yang dicek:</strong>
                            @foreach ($ip_perusahaan as $ip)
                                <span class="badge bg-info">{{ $ip }}</span>
                            @endforeach
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Waktu</th>
                                        <th>No Akun</th>
                                        <th>IP Publik</th>
                                        <th>Status</th>
                                        <th>Baris Log</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ipCompanyLogs as $i => $row)
                                        <tr>
                                            <td>{{ $i + 1 }}</td>
                                            <td>{{ $row['tanggal'] }}</td>
                                            <td>{{ $row['waktu'] }}</td>
                                            <td>
                                                {{ $row['no_akun'] ?? '-' }}
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    {{ $row['ip'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-success">
                                                    IP Perusahaan
                                                </span>
                                            </td>
                                            <td style="max-width:500px;">
                                                <small class="text-muted">
                                                    {{ $row['raw'] }}
                                                </small>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center text-muted">
                                                Tidak ditemukan baris journal dengan IP perusahaan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <form action="{{ route('journal.save.ip-perusahaan') }}" method="POST" class="mt-3">
                            @csrf
                            <button class="btn btn-outline-success btn-sm mb-2">
                                <svg class="icon me-2">
                                    <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-save">
                                    </use>
                                </svg>
                                Simpan IP Perusahaan
                            </button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Hasil Pencarian Credit Facility</h5>
                    </div>
                    <div class="card-body">
                        @if (count($creditFacility))
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Ip Address</th>
                                            <th>Nomor Akun</th>
                                            <th>Nomor Tiket</th>
                                            <th>Credit In</th>
                                            <th>Credit Out</th>
                                            <th>Baris Log</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($creditFacility as $i => $line)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $line['tanggal'] }}</td>
                                                <td>{{ $line['waktu'] }}</td>
                                                <td>{{ $line['ip_address'] }}</td>
                                                <td>{{ $line['no_akun'] }}</td>
                                                <td>{{ $line['no_tiket'] }}</td>
                                                <td>{{ $line['credit_in'] }}</td>
                                                <td>{{ $line['credit_out'] }}</td>
                                                <td>{{ $line['raw'] }}</td>
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
                            <button class="btn btn-outline-success btn-sm mb-2">
                                <svg class="icon me-2">
                                    <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-save">
                                    </use>
                                </svg>
                                Simpan Credit Facility
                            </button>
                        </form>
                    </div>
                </div>


                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Hasil Pencarian Market Execution</h5>
                    </div>
                    <div class="card-body">
                        @if (count($marketExecution))
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>No Akun</th>
                                            <th>No Tiket</th>
                                            <th>Request</th>
                                            <th>Confirm</th>
                                            <th>Delay (Detik)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($marketExecution as $i => $row)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>{{ $row['tanggal'] }}</td>
                                                <td>{{ $row['no_akun'] }}</td>
                                                <td>{{ $row['no_tiket'] }}</td>

                                                <td>{{ $row['request_raw'] }}</td>
                                                <td>{{ $row['confirm_raw'] }}</td>

                                                <td class="text-danger fw-bold">
                                                    {{ $row['delay_formatted'] }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Tidak ditemukan eksekusi market yang delay lebih dari 1 detik.</p>
                        @endif

                        <form method="POST" action="{{ route('journal.save.market') }}">
                            @csrf
                            <button class="btn btn-outline-success btn-sm mb-2">
                                <svg class="icon me-2">
                                    <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-save">
                                    </use>
                                </svg>
                                Simpan Market Execution
                            </button>
                        </form>
                    </div>
                </div>


                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Hasil Pencarian Harga Tidak Sesuai</h5>
                    </div>
                    <div class="card-body">
                        @if (count($wrongPrice))
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-primary">
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal</th>
                                            <th>No Akun</th>
                                            <th>No Tiket</th>
                                            <th>Confirm</th>
                                            <th>Close Order</th>
                                            <th>Exec Type</th>
                                            <th>Completed</th>
                                            <th>Bid</th>
                                            <th>Ask</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($wrongPrice as $i => $row)
                                            <tr>
                                                <td>{{ $i + 1 }}</td>
                                                <td>
                                                    {{ $row['tanggal'] }}
                                                </td>
                                                <td>
                                                    {{ $row['no_akun'] }}
                                                </td>
                                                <td>
                                                    {{ $row['no_tiket'] }}
                                                </td>
                                                <td>
                                                    {{ $row['confirm'] }}
                                                </td>
                                                <td>
                                                    {{ $row['close_order'] }}
                                                </td>

                                                <td class="fw-bold text-primary">
                                                    {{ strtoupper($row['exec_type']) }}
                                                </td>

                                                <td class="fw-bold text-danger">{{ $row['completed'] }}</td>
                                                <td>{{ $row['bid'] }}</td>
                                                <td>{{ $row['ask'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted">Tidak ada harga tidak sesuai.</p>
                        @endif

                        <form method="POST" action="{{ route('journal.save.wrong') }}">
                            @csrf
                            <button class="btn btn-outline-success btn-sm mb-2">
                                <svg class="icon me-2">
                                    <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-save">
                                    </use>
                                </svg>
                                Simpan Harga Tidak Sesuai
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
