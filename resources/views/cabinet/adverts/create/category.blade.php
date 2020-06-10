@extends('layouts.adverts')

@section('content')
    @include('cabinet.adverts._nav')

    <p>Choose category:</p>

    @include('cabinet.adverts.create._categories', ['categories' => $categories])

@endsection