@if ($errors->any())
    <ul class="notification text-danger text-center">
        @foreach ($errors->all() as $error)
            <li>
                {{ $error }}
            </li>
        @endforeach
    </ul>
@endif