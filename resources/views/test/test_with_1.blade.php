@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Dashboard - test_with_1</div>
                    @php
                        dump(session('success'));
                    @endphp
                </div>
            </div>
        </div>
    </div>
@endsection