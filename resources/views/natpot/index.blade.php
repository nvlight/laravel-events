@extends('layouts.event')

@section('content')

    <h2>Натяжные потолки</h2>

    <section class="natpot_calc_section">
        <h4 style="margin-top: 30px;"><a href="{{route('natpot.index')}}">Калькулятор стоимости</a></h4>
        <h5 style="margin-top: 25px; margin-bottom: 25px;">Заполните и отправьте заявку для расчета стоимости потолка. Калькулятор считает точную цену, которая не изменится на замере.</h5>

        <div>
            @if (isset($calculated))
{{--                {!! \App\Models\MGDebug::d($calculated) !!}--}}
            @endif
        </div>


        @if ((old('natpot_type')))
            {{old('natpot_type')}}
        @endif

        <form action="{{ route('natpot.calculate') }}" method="POST">
            <table class="table table-bordered table-striped">
                @csrf
                <caption>Таблица с данными потолка</caption>

                <tbody>
                    <tr>
                        <td><label for="natpot_type"><strong>Вид потолка</strong></label></td>
                        <td>
                            <select name="natpot_type" id="natpot_type" class="form-control">
                                <option value="0">Выберите тип потолка</option>
                                @if ( isset($fixedNatpotData) ) )
                                    @foreach($fixedNatpotData as $natpot)
                                        @if (isset($natpot['child']))
                                            <optgroup label="{{ $natpot['optgroup_label'] }}">
                                                @foreach($natpot['child'] as $child)
                                                    <option
                                                        @if ($child['value'] == $natpotType) selected @endif
                                                        @if ($child['value'] == old('natpot_type')) selected @endif
                                                        value="{{ $child['value'] }}">{!! $child['text'] !!}
                                                    </option>
                                                @endforeach
                                            </optgroup>
                                        @else
                                            @foreach($natpot as $main)
                                                <option
                                                    @if ($main['value'] == $natpotType) selected @endif
                                                    @if ($main['value'] == old('natpot_type')) selected @endif
                                                    value="{{ $main['value'] }}">{!! $main['text'] !!}
                                                </option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            </select>
                            @include('natpot.show_error', ['param' => 'natpot_type'])
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;"><strong>Исходные данные сторон (кв. м)</strong></td>
                    </tr>

                    <tr>
                        @php $sv = 0; @endphp
                        <td><label for="st1">Сторона A</label></td>
                        <td>
                            <input class="form-control" id="st1" name="st1" type="text" value="{{old('st1', $sides[$sv++])}}" placeholder="кв.м.">
                            @include('natpot.show_error', ['param' => 'st1'])
                        </td>
                    </tr>

                    <tr>
                        <td><label for="st2">Сторона B</label></td>
                        <td>
                            <input class="form-control" id="st2" name="st2" type="text" value="{{old('st2', $sides[$sv++])}}" placeholder="кв.м.">
                            @include('natpot.show_error', ['param' => 'st2'])
                        </td>
                    </tr>
                    <tr>
                        <td><label for="st3">Сторона C</label></td>
                        <td>
                            <input class="form-control" id="st3" name="st3" type="text" value="{{old('st3', $sides[$sv++])}}" placeholder="кв.м.">
                            @include('natpot.show_error', ['param' => 'st3'])
                        </td>
                    </tr>
                    <tr>
                        <td><label for="st4">Сторона D</label></td>
                        <td>
                            <input class="form-control" id="st4" name="st4" type="text" value="{{old('st4', $sides[$sv++])}}" placeholder="кв.м.">
                            @include('natpot.show_error', ['param' => 'st4'])
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;">
                            <a href=""><strong>Добавить еще 1 сторону</strong></a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;"><strong>Дополнительные параметры</strong></td>
                    </tr>
                    <tr>
                        <td>
                            <label for="chandeliers">Люстры</label>
                        </td>
                        <td>
                            <input class="form-control" id="chandeliers" name="chandeliers" type="text"
                                   value="{{$chandeliers ?? 0}}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="fixtures">Светильники</label>
                        </td>
                        <td>
                            <input class="form-control" id="fixtures" name="fixtures" type="text"
                                   value="{{$fixtures ?? 0}}">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="pipes">Трубы</label>
                        </td>
                        <td>
                            <input class="form-control" id="pipes" name="pipes" type="text"
                                   value="{{$pipes ?? 0}}">
                        </td>
                    </tr>

                    @if (isset($calculated))
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <strong>Результаты подсчетов</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="Perimeter">Периметр</label>
                            </td>
                            <td>
                                <input class="form-control" id="Perimeter" type="text" value="{{$calculated['perimeter']}} м." disabled >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="Square">Площадь</label>
                            </td>
                            <td>
                                <input class="form-control" id="Square" type="text"
                                   value="{{$calculated['square_ceil']}} кв.м. ({{$calculated['square']}} кв.м.)" disabled >
                            </td>
                        </tr>
                        <tr>
                            <td><label for="сeiling_one_square_summ">Стоимость 1 кв.м. потолка</label></td>
                            <td><input class="form-control" id="сeiling_one_square_summ" type="text"
                                       value="{{$calculated['сeiling_one_square_summ']}} {{$rusRoubleChar}}" disabled ></td>
                        </tr>
                        <tr>
                            <td><label for="сeiling_squares_summ">Стоимость потолка</label></td>
                            <td><input class="form-control" id="сeiling_squares_summ" type="text"
                                    value="{{$calculated['сeiling_squares_summ']}} {{$rusRoubleChar}}" disabled ></td>
                        </tr>

                        <tr>
                            <td><label for="chandFixPipesSumm">Люстры, светильники, трубы</label></td>
                            <td><input class="form-control" id="chandFixPipesSumm" type="text"
                                       value="{{$calculated['chandFixPipesSumm']}} {{$rusRoubleChar}}" disabled ></td>
                        </tr>


                        <tr>
                            <td>
                                <label for="baget">Багеты (расходник)</label>
                            </td>
                            <td>
                                <input class="form-control" id="baget" type="text"
                                       value="{{$calculated['bagets_amount_ceil']}} ({{$calculated['bagets_amount']}}) м, {{$calculated['bagets_cost']}} {{$rusRoubleChar}} " disabled >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="dubGvozdi">Дюбель-гвозди (6 x 40 мм) (расходник)</label>
                            </td>
                            <td>
                                <input class="form-control" id="dubGvozdi" type="text"
                                       value="{{$calculated['dubgv_amount']}} шт., {{$calculated['dubgv_cost']}} {{$rusRoubleChar}}" disabled >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="dubGvozdi">Саморезы по дереву (3.5 x 4.1 см) (расходник)</label>
                            </td>
                            <td>
                                <input class="form-control" id="dubGvozdi" type="text"
                                       value="{{$calculated['samor']['full_weight_ing_kg']}} кг., {{$calculated['samor']['full_cost']}} {{$rusRoubleChar}}" disabled >
                            </td>
                        </tr>
                        <tr>
                            <td><label for="fuelCost">Затраты на топливо</label></td>
                            <td><input class="form-control" id="fuelCost" type="text"
                                       value="{{$fuelCost}} {{$rusRoubleChar}}" disabled ></td>
                        </tr>
                        <tr>
                            <td><label for="totalСonsumablesSumm">Стоимость расходников (общая) </label></td>
                            <td><input class="form-control" id="totalСonsumablesSumm" type="text"
                               value="{{$calculated['consumablesTotalSumm']}} {{$rusRoubleChar}}" disabled ></td>
                        </tr>
                        <tr>
                            <td><label for="totalSumm">Стоимость итоговая</label></td>
                            <td><input class="form-control" id="totalSumm" type="text"
                                value="{{$calculated['finalCost']}} {{$rusRoubleChar}}" disabled ></td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <button class="btn btn-success" type="submit">Рассчитать</button>
                            <button class="btn btn-primary" type="reset">Сбросить</button>
                        </td>
                    </tr>

                </tbody>

            </table>
        </form>
    </section>

@endsection