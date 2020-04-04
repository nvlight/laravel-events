@extends('layouts.exchange_rate_template')

@section('content')

    <div class="result-exchange-rate">

        <h3>Курсы валют</h3>

        @if($gcer !== null)
            <h5>Курс на - {{\Illuminate\Support\Carbon::parse($gcer['Date'])->format('d.m.Y h:m:s')}}</h5>
    {{--        <div><span></span>{{\Illuminate\Support\Carbon::parse($gcer['Date'])->diffInDays(now(), false)}}</div>--}}
            @if(array_key_exists('Valute', $gcer))
                <table class="table table-striped table-bordered">

                    @if (count($gcer['Valute'][array_keys($gcer['Valute'])[0]]))
                        {{-- выводим шапку с названиями полей tr > th --}}
                        <?php $tmp = $gcer['Valute'][array_keys($gcer['Valute'])[0]]; $columns = []; ?>
                            @if(count($tmp))
                                <tr>
                                    @foreach( array_keys($tmp) as $k => $v )
                                        <?php $columns[] = $v; ?>
                                        @switch($v)
                                            @case('ID')
                                                @break
                                            @default
                                                <th>{{$v}}</th>
                                        @endswitch
                                    @endforeach
                                    <th>computed</th>
                                    <th>result</th>
                                </tr>
                            @endif

                        <?php //dd($columns); //dd(array_keys($gcer['Valute'])) ?>
                        {{-- вывод основных данных --}}
                        @foreach(array_keys($gcer['Valute']) as $k => $v)
                            @if (count($columns))
                                @if(in_array($gcer['Valute'][$v]['NumCode'], config('services.cbr.white_list') ) )
                                    <tr>
                                        @foreach($columns as $column)

                                            @switch($column)
                                                @case('ID')
                                                    @break
                                                @case('Value')
                                                    <td class="Value">{{$gcer['Valute'][$v][$column]}}</td>
                                                    @break
                                                @case('Nominal')
                                                    <td class="Nominal">{{$gcer['Valute'][$v][$column]}}</td>
                                                @break
                                                @default
                                                    <td>{{$gcer['Valute'][$v][$column]}}</td>
                                            @endswitch

                                        @endforeach

                                        <td>
                                            <input type="text" class="amount-computed-{{$gcer['Valute'][$v]['ID']}} exchange-rate-computed" value="">
                                        </td>
                                        <td>
                                            <input type="text" class="amount-result-{{$gcer['Valute'][$v]['ID']}} exchange-rate-result" disabled="">
                                        </td>
                                    </tr>
                                @endif
                            @endif
                        @endforeach
                    @else
                        <p>Нет данных для вывода</p>
                    @endif

                </table>
            @endif
        @endif
    </div>

    @php
        //dump($_SERVER);
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . 'exchange-rate-update';
    @endphp

    <script>

        fetch('<?=$url?>')
            .then(response => response.json())
            .then(data => {
                let el = document.querySelector(".result-exchange-rate");
                el.innerHTML = data['html'];
                //console.log('ok than!');
            });

        $('[class^=amount-computed]').on('keyup', function(e) {
            let parent_tr = $(this).parent().parent();
            let value = parent_tr.find('.Value').text();
            let nominal = parent_tr.find('.Nominal').text();
            let computed = ( (value * 1) / (nominal * 1) ) * ( $(this).val() * 1);
            parent_tr.find('.exchange-rate-result').val(computed.toFixed(2));
            console.log(value + ' : ' + nominal + ' --- ' + computed.toFixed(2));
        });

    </script>

@endsection