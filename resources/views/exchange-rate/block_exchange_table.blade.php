@if((isset($gcer['success']) && $gcer['success'] ))
    <h5>Курс на - {{\Illuminate\Support\Carbon::parse($gcer['data']['Date'])->format('d.m.Y h:m:s')}}</h5>

    @if(array_key_exists('Valute', $gcer['data']))
        <table class="table table-striped table-bordered">

            @if (count($gcer['data']['Valute'][array_keys($gcer['data']['Valute'])[0]]))
                {{-- выводим шапку с названиями полей tr > th --}}
                <?php $tmp = $gcer['data']['Valute'][array_keys($gcer['data']['Valute'])[0]]; $columns = []; ?>
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

                <?php
                    //dd($columns); //dd(array_keys($gcer['data']['Valute']))
                ?>
                {{-- вывод основных данных --}}
                @foreach(array_keys($gcer['data']['Valute']) as $k => $v)
                    @if (count($columns))
                        @if(in_array($gcer['data']['Valute'][$v]['NumCode'], config('services.cbr.white_list') ) )
                            <tr>
                                @foreach($columns as $column)

                                    @switch($column)
                                        @case('ID')
                                            @break
                                        @case('Value')
                                            <td class="Value">{{$gcer['data']['Valute'][$v][$column]}}</td>
                                            @break
                                        @case('Nominal')
                                            <td class="Nominal">{{$gcer['data']['Valute'][$v][$column]}}</td>
                                        @break
                                        @default
                                            <td>{{$gcer['data']['Valute'][$v][$column]}}</td>
                                    @endswitch

                                @endforeach

                                <td>
                                    <input type="text" class="amount-computed-{{$gcer['data']['Valute'][$v]['ID']}} exchange-rate-computed" value="">
                                </td>
                                <td>
                                    <input type="text" class="amount-result-{{$gcer['data']['Valute'][$v]['ID']}} exchange-rate-result" disabled="">
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
@else
    <h5 class="exchangeRateError">Данные не найдены, попробуйте позднее или нажмите на кнопку UpdateRates</h5>
@endif