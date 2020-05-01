<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequestStore;
use App\Models\Event\Category;
use App\Models\Event\Event;
use App\Models\Event\Type;
use App\Debug;
use App\Models\MGDebug;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Validator;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        User::whereId(Auth::user()->id)
//            ->with('events', 'types', 'categories')
//            ->first();

        $events = DB::table('users')
            ->join('events', 'events.user_id','=', 'users.id')
            ->join('types','types.id','=','events.type_id')
            ->join('categories','categories.id', '=', 'events.category_id')
            ->where('users.id','=',auth()->id())
            //->select('users.*','events.*','categories.*','types.*',)
            ->select('events.id', 'categories.name as category_name',
                'events.date', 'events.description', 'events.amount', 'types.name as type_name', 'types.color')
            ->orderBy('date','desc')
            ->paginate(config('services.events.paginate_number'));
            //->count();
            //->toSql()
            //->get()
        ;
        //dd($events);
        // после переделать ^ используя reletions
        //$events = auth()->user()->events()->caregories;
        //$events = auth()->user()->load('events', 'types', 'categories')->toArray();
        //$events = \App\User::whereId(auth()->user()->id)->with('events', 'types', 'categories')->first();

        //echo Debug::d($events); die;
        //dd($events);

        return view('event.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('user_id', '=', auth()->id() )->get();
        $types = Type::where('user_id', '=', auth()->id() )->get();
        
        //dd($categories);

        return view('event.create', compact('categories', 'types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EventRequestStore $request)
    {
        //$attributes = $this->validateEvent();
        $attributes = $request->validated();
        //dd($attributes);

        $attributes += ['user_id' => auth()->id()];
        $attributes['date'] =  Carbon::parse($attributes['date'])->format('Y-m-d');
        //echo Debug::d($attributes); die;

        Event::create($attributes);

        session()->flash('event_created','Событие создано');

        return redirect('/event');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event\Event$event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        //echo Debug::d($event->toArray()); die;
        //$this->authorize('view', $event);
        //abort_if(Gate::denies('view', $event), 403);
        abort_if(auth()->user()->cannot('view', $event), 403);

        return view('event.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        abort_if(auth()->user()->cannot('view', $event), 403);

        $categories = Category::where('user_id', '=', auth()->id() )->get();
        $types = Type::where('user_id', '=', auth()->id() )->get();
        $event->date = Carbon::parse($event->date)->format('d.m.Y');
        //echo Debug::d($event->date); die;
        return view('event.edit', compact('event', 'categories', 'types') );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\EventRequestStore $request
     * @param \App\Models\Event\Event $event
     */
    public function update(EventRequestStore $request, Event $event)
    {
        abort_if(auth()->user()->cannot('view', $event), 403);

        $attributes = $request->validated();
        $event->category_id = $attributes['category_id'];

        $event->type_id = $attributes['type_id'];
        $event->date =  $event->date = Carbon::parse( $attributes['date'])->format('Y-m-d');;
        $event->amount = $attributes['amount'];
        $event->description = $attributes['description'];
        $event->save();

        session()->flash('event_updated','Событие обновлено');

        return redirect('/event');
    }

    public function destroy(Event $event)
    {
        abort_if(auth()->user()->cannot('view', $event), 403);

        $event->delete();
        session()->flash('event_deleted','Событие удалено!');
        return redirect('/event');
    }

    /*
     * getEventsYear
     *
     * */
    public function getEventsYears()
    {
        $q = DB::table('events')
            ->select(DB::raw('DISTINCT(YEAR(events.date)) as year'))
            ->from('events')
            ->where('events.user_id', auth()->id())
            //->toSql();
            ->get()->pluck('year')->toArray();
        return $q;
    }

    /*
     * graphics_index...
     *
     * */
    public function graphics_index(\Request $request)
    {
        $eventYears = $this->getEventsYears();

        // получаем дату из запроса, если ее нет, то берем текущий год
        $year = \request()->exists('year');
        if ($year){
            $year = \request('year');
            if (!preg_match("#^[0-9]{4}$#u",$year))
                $year = Date('Y');
        }else{
            $year = Date('Y');
        }

        // !!! после нужно сделать этот массив входным из ГЕТ-а
        $type_ids = [1,2];

        // получение данных всех диаграмм - сырые данные
        $qr = $this->getQueryRs($year, $type_ids); //
        //dd($qr);

        $pie_data = $this->getPieData($qr[0]->toArray(), $year); // готовые данные 1 диаграммы

        $series2 = ($qr[1]); // готовый для вставки в диаграмму массив

        // массив для теста диаграммы №2, генерирует данные автоматически
        $series0 = [
            [
                'name'  => 'Доход',
                'colorByPoint' => true,
                'color' => '#5CB85C',
                'data' => [
                    [ 'name' => 'Доход',
                        'y' => rand(3000,50001),
                        'color' => '#5CB85C'
                    ],
                    [ 'name' => 'Доход',
                        'y' => rand(3000,50001),
                        'color' => '#5CB85C'
                    ],
                    [ 'name' => 'Доход',
                        'y' => rand(3000,50001),
                        'color' => '#5CB85C'
                    ],
                    [ 'name' => 'Доход',
                        'y' => rand(3000,50001),
                        'color' => '#5CB85C'
                    ],
                    [ 'name' => 'Доход',
                        'y' => rand(3000,50001),
                        'color' => '#5CB85C'
                    ],
                    [ 'name' => 'Доход',
                        'y' => rand(3000,50001),
                        'color' => '#5CB85C'
                    ],
                    [ 'name' => 'Доход',
                        'y' => rand(3000,50001),
                        'color' => '#5CB85C'
                    ],
                    [ 'name' => 'Доход',
                        'y' => rand(3000,50001),
                        'color' => '#5CB85C'
                    ],
                    [ 'name' => 'Доход',
                        'y' => rand(3000,50001),
                        'color' => '#5CB85C'
                    ],
                    [ 'name' => 'Доход',
                        'y' => rand(3000,50001),
                        'color' => '#5CB85C'
                    ],
                    [ 'name' => 'Доход',
                        'y' => rand(3000,50001),
                        'color' => '#5CB85C'
                    ],
                    [ 'name' => 'Доход',
                        'y' => rand(3000,50001),
                        'color' => '#5CB85C'
                    ],
                ],
            ],
            [
                'name'  => 'Расход',
                'colorByPoint' => true,
                'color' => '#D9534F',
                'data' => [
                    [ 'name' => 'Расход',
                        'y' => rand(3000,50001),
                        'color' => '#D9534F'
                    ],
                    [ 'name' => 'Расход',
                        'y' => rand(3000,50001),
                        'color' => '#D9534F'
                    ],
                    [ 'name' => 'Расход',
                        'y' => rand(3000,50001),
                        'color' => '#D9534F'
                    ],
                    [ 'name' => 'Расход',
                        'y' => rand(3000,50001),
                        'color' => '#D9534F'
                    ],
                    [ 'name' => 'Расход',
                        'y' => rand(3000,50001),
                        'color' => '#D9534F'
                    ],
                    [ 'name' => 'Расход',
                        'y' => rand(3000,50001),
                        'color' => '#D9534F'
                    ],
                    [ 'name' => 'Расход',
                        'y' => rand(3000,50001),
                        'color' => '#D9534F'
                    ],
                    [ 'name' => 'Расход',
                        'y' => rand(3000,50001),
                        'color' => '#D9534F'
                    ],
                    [ 'name' => 'Расход',
                        'y' => rand(3000,50001),
                        'color' => '#D9534F'
                    ],
                    [ 'name' => 'Расход',
                        'y' => rand(3000,50001),
                        'color' => '#D9534F'
                    ],
                    [ 'name' => 'Расход',
                        'y' => rand(3000,50001),
                        'color' => '#D9534F'
                    ],
                    [ 'name' => 'Расход',
                        'y' => rand(3000,50001),
                        'color' => '#D9534F'
                    ],
                ],
            ]
        ];
        //echo Debug::d($series2,'',2);
        //echo Debug::d($series0,'',2); die;
        //$series2 = $series0;

        // сюда приходит общие суммы по всем годам, а нужно, чтобы приходил только текущий год...
        $chart2 = \Chart::title([
            'text' => 'Сумма ресурсов по типам',
        ])
            ->chart([
                'type'     => 'pie', // pie , column ect
                'renderTo' => 'chart2', // render the chart into your div with id
            ])->subtitle(['text' => 'Диаграмма типа \'пирог\'', ])
            ->colors(['#0c2959','#900'])
            ->plotOptions([
                'pie' => [
                        'allowPointSelect' => true,
                        'cursor' => 'pointer',
                        'dataLabels' => [
                            'enabled' => true
                        ],
                        'showInLegend' => true
                    ]
            ])
            ->xaxis([
                'categories' => [
                    'Alex Turner',
                    'Julian Casablancas',
                    'Bambang Pamungkas',
                    'Mbah Surip',
                ],
                'labels'     => [
                    'rotation'  => 15,
                    'align'     => 'top',
                    'formatter' => 'startJs:function(){return this.value + " (Footbal Player)"}:endJs',
                    // use 'startJs:yourjavasscripthere:endJs'
                ],
            ])
            ->yaxis([
                'text' => 'This Y Axis',
            ])
            ->legend([
                'layout'        => 'vertikal',
                'align'         => 'right',
                'verticalAlign' => 'middle',
            ])
            ->series(
                [
                    [
                        'name'  => 'Сумма',
                        'colorByPoint' => true,
                        'data' => $pie_data,
                        //'data'  => [43934, 52503],
                        //'color' => ['#fff', '#000'],
                    ]

//                    [
//                        'data' =>
//                        [
//                            'name'=> 'Point 1',
//                            'color'=> '#00FF00',
//                            'y' => 0
//                        ]
//                    ]

                ]
            )
            ->display();

        // этот код формирует рендомные данные для месяцев с доходами и расходами.
        // нужно теперь тоже самое, но с данными из бд...
//        $chart1 = \Chart::title([
//             'text' => 'Комбинированный график хождения денежных потоков',
//             ])
//            ->chart([
//                'type'     => 'column', // pie , column ect
//                'renderTo' => 'chart1', // render the chart into your div with id
//            ])->subtitle(['text' => '', ])
//            ->colors(['#0c2959','#900'])
//            ->plotOptions([
//                'column' => [
//                    'dataLabels' => [
//                        'enabled' => true
//                    ],
//                ]
//            ])
//            ->xaxis([
//                'categories' => [
//                    'january','february','march','april','may','june','july','august','september','october','november','december',
//                ],
//
//            ])
//            ->yaxis([
//                'text' => 'This Y Axis',
//            ])
//            ->legend([
//                'layout'        => 'vertikal',
//                'align'         => 'right',
//                'verticalAlign' => 'middle',
//            ])
//            ->series(
//                [
//                    [
//                        'name'  => 'Доход',
//                        'colorByPoint' => true,
//                        'color' => '#5CB85C',
//                        'data' => [
//                            [ 'name' => 'Доход',
//                               'y' => rand(3000,50001),
//                                'color' => '#5CB85C'
//                            ],
//                            [ 'name' => 'Доход',
//                                'y' => rand(3000,50001),
//                                'color' => '#5CB85C'
//                            ],
//                            [ 'name' => 'Доход',
//                                'y' => rand(3000,50001),
//                                'color' => '#5CB85C'
//                            ],
//                            [ 'name' => 'Доход',
//                                'y' => rand(3000,50001),
//                                'color' => '#5CB85C'
//                            ],
//                            [ 'name' => 'Доход',
//                                'y' => rand(3000,50001),
//                                'color' => '#5CB85C'
//                            ],
//                            [ 'name' => 'Доход',
//                                'y' => rand(3000,50001),
//                                'color' => '#5CB85C'
//                            ],
//                            [ 'name' => 'Доход',
//                                'y' => rand(3000,50001),
//                                'color' => '#5CB85C'
//                            ],
//                            [ 'name' => 'Доход',
//                                'y' => rand(3000,50001),
//                                'color' => '#5CB85C'
//                            ],
//                            [ 'name' => 'Доход',
//                                'y' => rand(3000,50001),
//                                'color' => '#5CB85C'
//                            ],
//                            [ 'name' => 'Доход',
//                                'y' => rand(3000,50001),
//                                'color' => '#5CB85C'
//                            ],
//                            [ 'name' => 'Доход',
//                                'y' => rand(3000,50001),
//                                'color' => '#5CB85C'
//                            ],
//                            [ 'name' => 'Доход',
//                                'y' => rand(3000,50001),
//                                'color' => '#5CB85C'
//                            ],
//                        ],
//                    ],
//                    [
//                        'name'  => 'Расход',
//                        'colorByPoint' => true,
//                        'color' => '#D9534F',
//                        'data' => [
//                            [ 'name' => 'Расход',
//                                'y' => rand(3000,50001),
//                                'color' => '#D9534F'
//                            ],
//                            [ 'name' => 'Расход',
//                                'y' => rand(3000,50001),
//                                'color' => '#D9534F'
//                            ],
//                            [ 'name' => 'Расход',
//                                'y' => rand(3000,50001),
//                                'color' => '#D9534F'
//                            ],
//                            [ 'name' => 'Расход',
//                                'y' => rand(3000,50001),
//                                'color' => '#D9534F'
//                            ],
//                            [ 'name' => 'Расход',
//                                'y' => rand(3000,50001),
//                                'color' => '#D9534F'
//                            ],
//                            [ 'name' => 'Расход',
//                                'y' => rand(3000,50001),
//                                'color' => '#D9534F'
//                            ],
//                            [ 'name' => 'Расход',
//                                'y' => rand(3000,50001),
//                                'color' => '#D9534F'
//                            ],
//                            [ 'name' => 'Расход',
//                                'y' => rand(3000,50001),
//                                'color' => '#D9534F'
//                            ],
//                            [ 'name' => 'Расход',
//                                'y' => rand(3000,50001),
//                                'color' => '#D9534F'
//                            ],
//                            [ 'name' => 'Расход',
//                                'y' => rand(3000,50001),
//                                'color' => '#D9534F'
//                            ],
//                            [ 'name' => 'Расход',
//                                'y' => rand(3000,50001),
//                                'color' => '#D9534F'
//                            ],
//                            [ 'name' => 'Расход',
//                                'y' => rand(3000,50001),
//                                'color' => '#D9534F'
//                            ],
//                        ],
//                    ]
//                ]
//            )
//            ->display();

        $chart1 = \Chart::title([
            'text' => 'Комбинированный график хождения денежных потоков',
        ])
            ->chart([
                'type'     => 'column', // pie , column ect
                'renderTo' => 'chart1', // render the chart into your div with id
            ])->subtitle(['text' => '', ])
            ->colors(['#0c2959','#900'])
            ->plotOptions([
                'column' => [
                    'dataLabels' => [
                        'enabled' => true
                    ],
                ]
            ])
            ->xaxis([
                'categories' => $qr[2],
                    //['january','february','march','april','may','june','july','august','september','october','november','december',],
            ])
            ->yaxis([
                'text' => 'This Y Axis',
            ])
            ->legend([
                'layout'        => 'vertikal',
                'align'         => 'right',
                'verticalAlign' => 'middle',
            ])
            ->series(
                $series2
                //$series0
            )
            ->display();

        return view('event.graphics', [
            'chart1' => $chart1,
            'chart2' => $chart2,
            'eventYears' => $eventYears
        ]);
    }

    /*
     * getSeriesForGraphic2...
     * */
    public function getSeriesForGraphic2($arr, $type_ids=[1,2]){

        $na = [];
//        [1] => 26000
//        [1_type_name] => доход
//        [1_color] => 5CB85C
//        [2] => 34200
//        [2_color] => D9534F

        foreach($type_ids as $kk => $vv){
            //echo Debug::d($v);
//            [
//                'name'  => 'Доход',
//                'colorByPoint' => true,
//                'color' => '#5CB85C',
//                'data' => [
//                    [ 'name' => 'Доход',
//                        'y' => rand(3000,50001),
//                        'color' => '#5CB85C'
//                    ],
            $tmp = [];
            foreach ($arr as $k => $v) {
                //echo Debug::d($v,'vv: '.$vv); die;

                if (array_key_exists($vv, $v)){
//                    try {
                        $tmp[] = [
                            'name' => $v[$vv . '_type_name'],
                            'y' => $v[$vv],
                            'color' => $v[$vv . '_color']
                        ];
//                    }catch (Exception $e){
//                        echo Debug::d($e,''); die;
//                    }
                }
            }
            if (count($tmp))
                $na[$vv] = [
                    'name' => 'name: ' . $vv,
                    'colorByPoint' => true,
                    'color' => '#ccc',
                    'data' => $tmp
                ];
        }
        //echo Debug::d($na); die;

        return array_values($na);
    }

    /*
     * getQueryRs...
     *
     * */
    public function getQueryRs($year, $type_ids)
    {
        // получим тут общую сумму по 4-м типам для текущего пользователя
        $q = DB::table('events')
            ->select(
                'events.type_id as tp', DB::raw('SUM(events.amount) as  sm'), 'types.name  as nm', 'types.color as cl'
            )
            ->from('events')
            ->whereIn('events.type_id', $type_ids)
            ->where('events.user_id', auth()->id())
            ->join('types','types.id','=','events.type_id')
            ->where(DB::raw('year(events.date)'), '=', $year)
            ->groupBy('tp')
            ->orderBy('tp')
            ->get();
        //dd($q);

        // получение данных для второй диаграммы с месяцами и расходами с доходами
        // запрос рабочий
        //SELECT
        //year(events.date) as dtr,
        //month(events.date) as mnth_id,
        //monthname(events.date) as mnthnm,
        //`events`.amount AS 'summ',
        //`events`.type_id AS tid,
        //types.NAME,
        //types.color
        //
        //from `events`
        //LEFT JOIN types ON types.id = `events`.type_id
        //
        //WHERE `events`.`user_id` = 1  and year(events.date) = 2019 AND `events`.type_id IN (1,2)
        //GROUP BY summ,tid,mnthnm,mnth_id,dtr
        //ORDER BY mnth_id, tid

        $q_get_years_with_months = DB::table('events')
            ->select( DB::raw('year(events.date) as dtr'),
                DB::raw('month(events.date) as mnth'),
                DB::raw('monthname(events.date) as mnthnm'),
                'events.amount as sm',
                'events.type_id as tp',
                'types.name as nm',
                'types.color as cl')
            ->from('events')
            ->join('types','types.id','=','events.type_id')
            ->where('events.user_id', '=', auth()->id() )
            ->whereIn('events.type_id',$type_ids)
            ->where(DB::raw('year(events.date)'), '=', $year)
            //->groupBy('sm','tp','mnthnm','mnth','dtr')
            ->orderBy('mnth')->orderBy('tp')
            //->toSql()
            ->get()
            //->toArray()
        ;
        //dd($q_get_years_with_months);
        //echo MGDebug::d($q_get_years_with_months,'$q_get_years_with_months'); die;

        $monthSumms = $this->groupAmountsByMonths($q_get_years_with_months->toArray());
        //echo Debug::d($monthSumms); die;

        $months = $this->getMonthLabels(0);
        //echo Debug::d($months); die;

        $filledZeroMonths = $this->fillZerroEmptyMonths($monthSumms, $months);
        //echo Debug::d($filledZeroMonths); die;

        $series2 = $this->getSeriesForGraphic2($filledZeroMonths); // готовый для вставки в диаграмму массив

        return [$q, $series2, $months];
    }

    /*
     * Группировка месяцев по суммам
     * т.е. для каждого месяця есть типы, соответствующие типы нужно складывать
     */
    protected function groupAmountsByMonths($arr){
        $rs = [];
        // $break = 0; $doBreak = 30; // переменные старт и стоп для отладки
        foreach($arr as $k => $v){

            //!(array_key_exists('mnthnm', $rs) &&
            //  array_key_exists( 'tp', $rs['mnthnm']))
            if (array_key_exists($v->mnthnm, $rs))
            {
                if (array_key_exists( $v->tp, $rs[$v->mnthnm])) {
                    //echo "2<br>";
                    $rs[$v->mnthnm][$v->tp] += $v->sm;

                }else{
                    //echo "1<br>";
                    $rs[$v->mnthnm][$v->tp] = $v->sm;
                    $rs[$v->mnthnm][$v->tp . '_type_name'] = $v->nm;
                    $rs[$v->mnthnm][$v->tp . '_color'] = '#' . $v->cl;
                }

            }else{
                //echo "0<br>";
                $rs[$v->mnthnm][$v->tp] = $v->sm;
                $rs[$v->mnthnm][$v->tp . '_type_name'] = $v->nm;
                $rs[$v->mnthnm][$v->tp . '_color'] = '#' . $v->cl;
            }

            // далее идет отладочный код
            //$break++;
            //if ($break == $doBreak) {
            //    echo Debug::d($rs,'break and die'); die;
            //}
        }

        return $rs;
    }

    /*
     * группировка месяцев по суммам, дополняя несуществующие месяцы нулями, со всеми типами
     *
     * */
    protected function fillZerroEmptyMonths($arr, $months)
    {
        $nrs = [];

        foreach($months as $month)
        if (!array_key_exists($month, $arr)){
            $nrs[$month] = [];
        }else{
            $nrs[$month] = $arr[$month];
        }

        return $nrs;
    }

    /*
     * получение названий всех месяцев на инглише
     *
     * */
    public function getMonthLabels($monthOffset=0)
    {
        $newArr = [];
        $time = strtotime("2017-01-01");
        $dtFormat = "F"; $monthOffset;
        for($i=0;$i<=11;$i++){
            $newMonth = $monthOffset + $i;
            $newArr[] = date($dtFormat, strtotime("+{$newMonth} month", $time));
        }
        return $newArr;
    }

    /*
     * формирует данные для диаграммы типа кусок пирога
     *
     * */
    public function getPieData($ob_rs)
    {
        //dd($ob_rs);
        // обработка и сбор 1 графика с общими сводками в серию
        $pie_data = [];
        if (isset($ob_rs) && is_array($ob_rs) && count($ob_rs)){
            $i = 4;
            foreach ($ob_rs as $k => $v){
                $pie_data[] = [
                    'name' => $v->nm . ': ' .  intval($v->sm),
                    'y' => intval($v->sm),
                    'color' => '#' . $v->cl,
                    //'dataLabels' => '111',
                    //'description' => '222',
                    'sliced' => true,
                    'selected' => $i == 1 ? true : false,
                ];
                $i++;
            }
        }

        return $pie_data;
    }

    /*
     * Main filter for events...
     *
     * */
    public function filter()
    {
        $date_regexp  = "/^([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))$/";
        $date_regexp2 = "/(0[1-9]|[12]\d|3[01])\.(0[1-9]|1[0-2])\.([12]\d{3})$/"; //

        $vld = Validator::make(request()->all(), [
            'category_id' => ['required','array','min:1'],
            'type_id' => ['required','array','min:1'],
            'date1' => ['required', "regex:".$date_regexp2],
            'date2' => ['required', "regex:".$date_regexp2],
            'amount1' => ['integer','min:0'],
            'amount2' => ['integer','min:0'],
            //'description' => ['string','min:3','max:55'],
        ]); //->validate();
        //dd($vld->failed());
        //dd($vld->fails());
        //dd(intval(\request('amount1')));
        $amount1 = intval(\request('amount1'));
        $amount2 = intval(\request('amount2'));
        $date_etalon1 = \request('date1');
        $date_etalon2 = \request('date2');
        $date1 = Carbon::parse($date_etalon1)->format('Y-m-d');
        $date2 = Carbon::parse($date_etalon2)->format('Y-m-d');
        $description = \request('description');

        //echo Debug::d($_REQUEST);
        $category_id = \request('category_id') ? \request('category_id') : [];
        $type_id     = \request('type_id') ? \request('type_id') : [];
        //echo Debug::d($category_id);
        //echo Debug::d($type_id);
        //dd($type_id);

        $categories = Category::where('user_id', '=', auth()->id() )->get();
        $types = Type::where('user_id', '=', auth()->id() )->get();
        //dd($types);

        $category_id_tmp = [];
        if (in_array(0, $category_id) ){
            $category_id = $categories;
            foreach($category_id as $value) $category_id_tmp[] = $value->id;
        }else {
            $category_id = Category::where('user_id', '=', auth()->id())
                ->whereIn('id', $category_id)
                ->get()
            ;
            foreach($category_id as $value) $category_id_tmp[] = $value->id;
        }
        //echo Debug::d($category_id); die;

        $type_id_tmp = [];
        if (in_array(0, $type_id)  ){
            $type_id = $types;

            foreach($type_id as $value) $type_id_tmp[] = $value->id;
        }else {
            $type_id = Type::where('user_id', '=', auth()->id())
                ->whereIn('id', $type_id)
                ->get()
            ;
            foreach($type_id as $value) $type_id_tmp[] = $value->id;
        }
//        echo Debug::d($category_id);
//        echo Debug::d($type_id);
//        echo Debug::d($category_id_tmp);
//        echo Debug::d($type_id_tmp);
        //die;

        $events = null; $events_count = 0;
        if (!$vld->fails()){
            $events = DB::table('users')
                ->join('events', 'events.user_id','=', 'users.id')
                ->join('types','types.id','=','events.type_id')
                ->join('categories','categories.id', '=', 'events.category_id')
                ->where('users.id','=',auth()->id())
            ;

            $description = preg_replace('/[^a-zа-я\d_-]+/ui','',$description);
            if (mb_strlen($description) >= 3 ) {
                $events = $events->where('description','like', '%' . $description . '%');
            }

            $events = $events
                ->whereBetween('amount', [$amount1, $amount2])
                ->whereBetween('date', [$date1, $date2])
                ->whereIn('category_id', $category_id_tmp )
                ->whereIn('events.type_id', $type_id_tmp ) // [1,2]

                ->select('events.id', 'categories.name as category_name',
                    'events.date', 'events.description', 'events.amount',
                    DB::raw(('(events.amount)')),
                    'types.name as type_name', 'types.color')
                //->groupBy('events.id', 'events.amount', 'types.id', 'date')
                ->orderBy('date','desc');

            $events_count = $events->count();

            $events = $events
                //->getBindings()
                //->get()
                //->toSql()
                ->paginate(config('services.events.paginate_number'))
            ;
        }
        //dd(count($events));
        //echo Debug::d($events); die;

        return view('event.filter', compact('categories', 'types', 'events', 'vld', 'description'
            ,'category_id', 'type_id', 'date_etalon1', 'date_etalon2', 'amount1', 'amount2', 'events_count') );
    }

}