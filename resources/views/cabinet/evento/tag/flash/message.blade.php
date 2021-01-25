@if(session()->has('crud_message'))
    <div class="{{ session()->get('crud_message')['class'] }}">
        {{ session()->get('crud_message')['message'] }}
    </div>
@endif