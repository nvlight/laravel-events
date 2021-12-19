@if ($errors->has($param))
    <ul class="notification text-danger text-center mb0">
        <li>{{ $errors->get($param)[0] }}</li>
    </ul>
@endif