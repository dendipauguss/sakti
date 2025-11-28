<div class="card mt-3">
    <div class="card-body">
        <h4>Waktu Eksekusi Market</h4>
        @foreach ($data as $item)
            <pre>{{ $item['request'] }}</pre>
            <pre>{{ $item['confirm'] }}</pre>
            <strong>Selisih: {{ $item['diff'] }} detik</strong>
            <hr>
        @endforeach
    </div>
</div>
