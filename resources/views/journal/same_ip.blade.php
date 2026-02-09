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
            {{-- <div class="col-md-12 mb-3">
                <h5>Jumlah baris: {{ count($parsed) }}</h5>
            </div> --}}
        </div>
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card shadow-sm mb-3">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">Hasil Pencarian IP Publik Sama Antar Journal Report Berbeda</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover" id="dataTables">
                            <thead class="table-dark">
                                <tr>
                                    <th>No</th>
                                    <th>IP</th>
                                    <th>Jumlah File</th>
                                    <th>Detail File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($duplicates as $ip => $files)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $ip }}</td>
                                        <td>{{ count($files) }}</td>
                                        <td>
                                            <ul class="list-group">
                                                @foreach ($files as $file => $row)
                                                    <li class="list-group-item bg-transparent border-0">Tanggal Waktu :
                                                        <b>{{ $row['tanggal'] }}
                                                            {{ $row['waktu'] }}</b> - No Akun : <b>{{ $row['no_akun'] }}</b>
                                                        - File :
                                                        <b>{{ $row['file'] }}</b>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form action="{{ route('journal.save.ip-publik') }}" method="POST" class="mt-3">
                            @csrf
                            <button class="btn btn-outline-success btn-sm mb-2">
                                <svg class="icon me-2">
                                    <use xlink:href="{{ env('THM_LINK') }}/vendors/@coreui/icons/svg/free.svg#cil-save">
                                    </use>
                                </svg>
                                Simpan IP Publik Sama
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
