@extends('layouts.app')
@section('content')
    <div class="container-lg px-4">
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        <form action="{{ route('equity.upload.process') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Pilih File Equity Report 1 (.htm)</label>
                                <input type="file" class="form-control" name="equity_file_1" required
                                    accept=".htm,.html">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Pilih File Equity Report 2 (.htm)</label>
                                <input type="file" class="form-control" name="equity_file_2" required
                                    accept=".htm,.html">
                            </div>

                            <button class="btn btn-primary">Upload & Proses</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
