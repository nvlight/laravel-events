@extends('layouts.event')

@section('content')

    <h3>Курсы валют</h3>

    @if($gcer !== null)
        <h5>{{$gcer['Date']}}</h5>
        <h5>{{$gcer['PreviousDate']}}</h5>
        <h5>{{$gcer['Timestamp']}}</h5>

        @if(array_key_exists('Valute', $gcer))
            <table class="table table-striped table-bordered">

                @if (count($gcer['Valute'][array_keys($gcer['Valute'])[0]]))
                    {{-- выводим шапку с названиями полей tr > th --}}
                    <?php $tmp = $gcer['Valute'][array_keys($gcer['Valute'])[0]]; $columns = []; ?>
                        @if(count($tmp))
                            <tr>
                                @foreach( array_keys($tmp) as $k => $v )
                                    <?php $columns[] = $v; ?>
                                    <th>{{$v}}</th>
                                @endforeach
                            </tr>
                        @endif

                    <?php //dd($columns); //dd(array_keys($gcer['Valute'])) ?>
                    {{-- вывод основных данных --}}
                    @foreach(array_keys($gcer['Valute']) as $k => $v)
                        @if (count($columns))
                            <tr>
                                @foreach($columns as $column)
                                    <td>{{$gcer['Valute'][$v][$column]}}</td>
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                @else
                    <p>Нет данных для вывода</p>
                @endif

            </table>
        @endif
    @endif

@endsection