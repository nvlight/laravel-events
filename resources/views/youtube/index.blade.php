@extends('layouts.event')

@section('content')

    <h3>YouTube</h3>
    
    <ul class="">
        <li>Search
            <form action="{{ route('youtube.search_redirect') }}">
                <input type="text" name="q" placeholder="video_id">
                <button type="submit" class="btn btn-success">search it</button>
            </form>
        </li>
        <li>show video
            <form action="{{ route('youtube.watch_redirect') }}">
                <input type="text" name="video_id" placeholder="video_id">
                <button type="submit" class="btn btn-success">show it!</button>
            </form>
        </li>
    </ul>
    
@endsection