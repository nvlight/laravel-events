@extends('layouts.event')

@section('content')
    <div class="result-exchange-rate-wrapper">

        <h3 class="d-flex flex-row justify-content-center">
            <span>Курсы валют</span>
            <button id="btnUpdateRate" class="btn btn-success d-flex ml-1 align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-counterclockwise exchangeRateUpdateSvg d-none" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"/>
                    <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"/>
                </svg>
                <span class="ml-1">Update Rates!</span>
            </button>
        </h3>

        <div class="result-exchange-rate">
            @include('exchange-rate.block_exchange_table')
        </div>
    </div>
    @include('exchange-rate.exchange-rate_compute')
@endsection