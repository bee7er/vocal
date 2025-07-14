@if (count($msgs) > 0)
        <!-- Form Msg List -->
    <div class="alert alert-success">
        <ul>
            @foreach ($msgs as $msg)
                <li>{{ $msg }}</li>
            @endforeach
        </ul>
    </div>
@endif