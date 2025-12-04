@extends('layouts.app')
@section('content')
    <section>
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

                        <form action="{{ route('journal.upload.process') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Pilih File Journal (.htm)</label>
                                <input type="file" class="form-control" name="file" required accept=".htm,.html">
                            </div>

                            <button class="btn btn-primary">Upload & Proses</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
