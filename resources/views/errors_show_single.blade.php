@if ($errors->has($column))
    <ul class="notification text-danger text-center">
        @foreach($errors->get($column) as $error)
            <li>
                {{ $error }}
            </li>
        @endforeach
    </ul>
@endif
