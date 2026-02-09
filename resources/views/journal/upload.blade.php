@extends('layouts.app')
@section('content')
    <div class="container-lg px-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <span class="fs-5">
                            Pengecekan IP Perusahaan, Credit Facility, Market Execution, dan Harga Tidak Sesuai</span>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('journal.upload.process') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">IP Perusahaan yang ingin di cek</label>
                                <input type="text" name="ip_perusahaan" id="ip_perusahaan"
                                    class="form-control @error('ip_perusahaan') is-invalid @enderror"
                                    placeholder="contoh: 192.168.1.1, 10.1.2.3">
                                @error('ip_perusahaan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pilih File Journal Report (.htm)</label>
                                <input type="file" class="form-control" name="file" required accept=".htm,.html">
                            </div>

                            <button class="btn btn-primary">Upload & Proses</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <span class="fs-5">
                            Perbandingan History Statement dan Journal Report Nasabah</span>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('journal.upload.compare') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Pilih File History Statement (.htm)</label>
                                <input type="file" class="form-control" name="history_statement" required
                                    accept=".htm,.html">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pilih File Journal Report (.htm)</label>
                                <input type="file" class="form-control" name="journal_report" required
                                    accept=".htm,.html">
                            </div>

                            <button class="btn btn-primary">Upload & Proses</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-header">
                        <span class="fs-5">
                            Pencarian IP Publik yang sama dalam beberapa Journal Report Nasabah</span>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('journal.upload.multi') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Pilih File Journal Report (.htm)</label>
                                <input type="file" class="form-control" name="files[]" required accept=".htm,.html"
                                    multiple>
                            </div>

                            <button class="btn btn-primary">Upload & Proses</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
