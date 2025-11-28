<div class="card mt-3">
    <div class="card-body">
        <h4>Harga Tidak Sesuai</h4>
        @foreach ($data as $item)
            <pre>{{ $item['confirm'] }}</pre>
            <pre>{{ $item['close'] }}</pre>
            <strong>Status: {{ $item['status'] }}</strong>
            <hr>
        @endforeach
    </div>
</div>
