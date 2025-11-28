<div class="card mt-3">
    <div class="card-body">
        <h4>Credit Facility</h4>
        @foreach ($data as $line)
            <pre>{{ $line }}</pre>
        @endforeach
    </div>
</div>
