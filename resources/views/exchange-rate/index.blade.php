@extends('layouts.event')

@section('content')
    @include('exchange-rate.block_exchange_table')
    @include('exchange-rate.exchange-rate_compute')
@endsection