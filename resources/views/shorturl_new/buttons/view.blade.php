@if (isset($item['id']))
    <a href="{{ route('shorturlnew_category.show', $item['id']) }}">
        <button class="mg-btn-1 " type="submit" title="просмотреть" >
            <svg viewBox="0 0 12 16" version="1.1" aria-hidden="true" class="mg-btn-show" width="20" height="20"><path fill-rule="evenodd" d="M6 5H2V4h4v1zM2 8h7V7H2v1zm0 2h7V9H2v1zm0 2h7v-1H2v1zm10-7.5V14c0 .55-.45 1-1 1H1c-.55 0-1-.45-1-1V2c0-.55.45-1 1-1h7.5L12 4.5zM11 5L8 2H1v12h10V5z"></path></svg>
        </button>
    </a>
@endif