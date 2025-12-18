@extends('layouts.app')
@section('content')
    <section>
        <div class="row">
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <table border="1" width="100%">
                            <tr>
                                <th>No Akun</th>
                                <th>No Tiket</th>
                                <th>Delay</th>
                            </tr>
                            @foreach ($data as $row)
                                <tr>
                                    <td>{{ $row->no_akun }}</td>
                                    <td>{{ $row->no_tiket }}</td>
                                    <td>{{ $row->delay_formatted }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
