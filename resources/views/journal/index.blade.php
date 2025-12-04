@extends('layouts.app')
@section('content')
    <section>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <a href="{{ route('journal.upload') }}" class="btn btn-sm btn-primary">+ Filter Baru</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
