<?php

namespace App\Http\Controllers\Natpot;

use App\Http\Requests\Natpot\CalculateRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MGDebug;

class NatpotController extends Controller
{
    CONST MAT_SAT_GLANEC__WHITE_32 = 130;
    CONST MAT_SAT_GLANEC__WHITE_4_5 = 170;
    CONST MAT_SAT_GLANEC__COLORED_32 = 175;
    CONST MAT_SAT_GLANEC__COLORED_4_5 = 240;
    CONST TEXTURED = 300; // фактурные
    CONST SPARKS = 330;   // искры
    CONST CLOUDS = 400;   // облака

    CONST BAGET_STEP = 0.18;     // with 2 dots
    CONST BAGET_ONE_COST = 25;   // kv.m.
    CONST BAGET_ONE_LENGTH = 2;  // m
    CONST BAGET_RESERVE_LENTH = 0.5;  // m

    CONST DUBGV_DIF_LENGTH = 0.18;   // длина между дюбль-гвоздями
    CONST DUBGV_RESERVE_AMOUNT = 33; // длина между дюбль-гвоздями
    CONST DUBGV_ONE_BOX_AMOUNT = 50;
    CONST DUBGV_ONE_BOX_WITH_50_COST = 100;

    CONST SAMOR_DIF_LENTH = 0.18;
    CONST SAMOR_RESERVE_AMOUNT = 33;

    CONST BROTHER_MULTIPLIER = 3;

    CONST SAMOR_ONE_ELEMENT_COST = 1.2; // rub
    CONST FUEL_FOR_ROAD_COST = 1000; // rub

    CONST CHANDELIERS_COST = 300;
    CONST FIXTURES_COST = 300;
    CONST PIPES_COST = 300;

    CONST RUSS_ROUBLE_CHAR = "₽";

    protected $sides = [];

    protected $samor = [];

    public function __construct()
    {
        $this->samor['3.5x4.1']['one_weight'] = 2.24;
    }

    public function index(Request $request)
    {
        $fixedNatpotData = $this->getFixedNatpots();
        $natpotType = 0;

        $sides = $this->getSides($request);

        return view('natpot.index', ['fixedNatpotData' => $fixedNatpotData, 'natpotType' => $natpotType,
                'sides' => $sides
            ]);
    }

    protected function getDubgvAmount($perimeter)
    {
        return $perimeter / self::DUBGV_DIF_LENGTH;
    }

    protected function getDubgvAmountReal($perimeter)
    {
        return $this->getDubgvAmount($perimeter) + self::DUBGV_RESERVE_AMOUNT;
    }

    protected function getDubgvBoxCount($perimeter)
    {
        return ceil( $this->getDubgvAmountReal($perimeter) / self::DUBGV_ONE_BOX_AMOUNT ) ;
    }

    protected function getDubgvAmountPlusBoxDiff($perimeter)
    {
        return $this->getDubgvBoxCount($perimeter) * self::DUBGV_ONE_BOX_AMOUNT ;
    }

    protected function getDubgvCost($perimeter)
    {
        return $this->getDubgvBoxCount($perimeter) * self::DUBGV_ONE_BOX_WITH_50_COST;
    }

    protected function number_in_range($a, $b, $number)
    {
        return ($a <= $number ) && ($number <= $b);
    }

    protected function squareTrapezoidBy4Sides($a, $b, $c, $d)
    {
        return (($a+$b)/2) * sqrt( $c*$c - pow( (pow( ($a-$b), 2) + $c*$c - $d*$d) / ( 2 * ($a - $b)) , 2 ) );
    }

    protected function getMinWidth($a, $b, $c, $d)
    {
        $sides = [$a, $b, $c, $d];

        unset($sides[array_search(min($sides), $sides)]);

        return min($sides);
    }

    protected function getPerimeter($a, $b, $c, $d)
    {
        return array_sum([$a, $b, $c, $d]);
    }

    protected function getSquareSimple($a, $b, $c, $d)
    {
        if ( ( ($a === $b) && ($b === $c) && ($c === $d) )  || ( ($a === $c) && ($b === $d) ) ){
            return $a * $b;
        }

        return $this->squareTrapezoidBy4Sides($a, $b, $c, $d);
    }

    protected function getMaxValAndKeyFromArray($a)
    {
        if (!count($a)) {
            return false;
        }

        $key = array_key_first($a);
        $value = $a[array_key_first($a)];
        foreach($a as $k => $v){
            if ($v > $value){
                $value = $v;
                $key = $k;
            }
        }

        return ['key' => $key, 'value' => $value];
    }

    /**
     * @param $a
     * @param $b
     * @param $c
     * @param $d
     * @return float|int
     */
    protected function getSquareNormal($a, $b, $c, $d)
    {
        $sides = $this->sides;
        $maxFirst = $this->getMaxValAndKeyFromArray($sides);
        unset($sides[$maxFirst['key']]);
        unset($sides[$this->getMaxValAndKeyFromArray($sides)['key']]);
        $maxSecond = $this->getMaxValAndKeyFromArray($sides);

        //dump($maxFirst);
        //dump($maxSecond);

        $square = $maxFirst['value'] * $maxSecond['value'];

        return $square;
    }

    protected function getCeilSquare($square)
    {
        return ceil($square);
    }

    protected function getBagetsCost($perimeter)
    {
        return self::BAGET_ONE_COST * $perimeter;
    }

    protected function getBagetsAmount($perimeter)
    {
        return $perimeter / self::BAGET_ONE_LENGTH;
    }

    protected function getBagetsAmountCeil($bagets)
    {
        return ceil($bagets);
    }

    protected function getMultiplier($natpotType, $minWidth)
    {
        //
        $multiplier = 1;
        switch ($natpotType){
            case 1:
            case 2:
            case 3:
                $calculated['1-3'] = 0;
                if ( $this->number_in_range(0, 3.2, $minWidth) ){
                    $multiplier = self::MAT_SAT_GLANEC__WHITE_32;   //130;
                }elseif( $this->number_in_range(3.2, 4, $minWidth) ){
                    $multiplier = self::MAT_SAT_GLANEC__WHITE_4_5; // 170;
                }else{
                    $multiplier = self::MAT_SAT_GLANEC__WHITE_4_5; // 170;
                }
                break;
            case 4:
            case 5:
            case 6:
                $calculated['4-6'] = 0;
                if ( $this->number_in_range(0, 3.2, $minWidth) ){
                    $multiplier = self::MAT_SAT_GLANEC__COLORED_32; //175;
                }elseif( $this->number_in_range(3.2, 4, $minWidth) ){
                    $multiplier = self::MAT_SAT_GLANEC__COLORED_4_5; //240;
                }else {
                    $multiplier = self::MAT_SAT_GLANEC__COLORED_4_5; //240;
                }
                break;
            case 7:
                $calculated['7'] = 0;
                if ( $this->number_in_range(0, 3.2, $minWidth) ){
                    $multiplier = self::TEXTURED;
                }
                break;
            case 8:
                $calculated['8'] = 0;
                if ( $this->number_in_range(0, 3.2, $minWidth) ){
                    $multiplier = self::SPARKS;
                }
                break;
            case 9:
                $calculated['9'] = 0;
                if ( $this->number_in_range(0, 3.2, $minWidth) ){
                    $multiplier = self::CLOUDS;
                }
                break;
            default:
                $multiplier = 1;
        }

        return $multiplier;
    }

    protected function getFixedNatpots()
    {
        $id = 0;
        $natpot = [
            [ 'optgroup_label' => "Белый. Ширина до 5 метров",
                'child' => [
                  ['value' => ++$id, 'text' => 'Матовый' ],
                  ['value' => ++$id, 'text' => 'Сатиновый' ],
                  ['value' => ++$id, 'text' => 'Глянцевый' ],
                ]
            ],
            [ 'optgroup_label' => "Цветной. Ширина до 5 метров",
                'child' => [
                    ['value' => ++$id, 'text' => 'Матовый' ],
                    ['value' => ++$id, 'text' => 'Сатиновый' ],
                    ['value' => ++$id, 'text' => 'Глянцевый' ],
                ]
            ],
            [
                ['value' => ++$id, 'text' => 'Фактурные (ширина до 3.2 метра)' ],
                ['value' => ++$id, 'text' => 'Искры (ширина до 3.2 метра)' ],
                ['value' => ++$id, 'text' => 'Облака (ширина до 3.2 метра)' ],
                ['value' => ++$id, 'text' => '<strong>Дескор</strong>' ],
            ],
        ];

        return $natpot;
    }

    protected function getSamorAmountReal($perimeter)
    {
        return round( $perimeter / self::SAMOR_DIF_LENTH ) + self::SAMOR_RESERVE_AMOUNT;
    }

    protected function getSamorFullCost($samorAmountReal)
    {
        return round(self::SAMOR_ONE_ELEMENT_COST * $samorAmountReal);
    }

    protected function getSamorWeight($samorAmountReal)
    {
        return $this->samor['3.5x4.1']['one_weight'] * $samorAmountReal;
    }

    protected function getSamorWeightInKG($samorWeight)
    {
        return round($samorWeight / 1000,2 );
    }

    protected function getChandFixPipesSumm($chandeliers, $fixtures, $pipes)
    {
        $chandeliersSumm = $chandeliers * self::CHANDELIERS_COST;
        $fixturesSumm = $fixtures * self::FIXTURES_COST;
        $pipesSumm = $pipes * self::PIPES_COST;

        return array_sum([$chandeliersSumm, $fixturesSumm, $pipesSumm]);
    }

    protected function calculateHandler($sides, $natpotType, $chandeliers, $fixtures, $pipes)
    {
        $calculated = [];

        $i = 0;
        $calculated['minWidth'] = $this->getMinWidth($sides[$i++], $sides[$i++], $sides[$i++], $sides[$i++]);
        $i = 0;
        $calculated['perimeter'] = $this->getPerimeter($sides[$i++], $sides[$i++], $sides[$i++], $sides[$i++]);
        $i = 0;
        $calculated['square'] = $this->getSquareNormal($sides[$i++], $sides[$i++], $sides[$i++], $sides[$i++]);

        $calculated['square_ceil'] = $this->getCeilSquare($calculated['square']);
        $calculated['bagets_amount'] = $this->getBagetsAmount($calculated['perimeter']) + self::BAGET_RESERVE_LENTH;
        $calculated['bagets_amount_ceil'] = $this->getBagetsAmountCeil($calculated['bagets_amount']);

        $calculated['bagets_cost'] = $this->getBagetsCost($calculated['bagets_amount']);
        $calculated['multiplier'] = $this->getMultiplier($natpotType, $calculated['minWidth']);
        $calculated['dubgv_amount'] = $this->getDubgvAmountPlusBoxDiff($calculated['perimeter']);
        $calculated['dubgv_cost'] = $this->getDubgvCost($calculated['perimeter']);
        $calculated['сeiling_one_square_summ'] = $calculated['multiplier'] * self::BROTHER_MULTIPLIER;
        $calculated['сeiling_squares_summ'] = $calculated['square_ceil'] * $calculated['multiplier'] * self::BROTHER_MULTIPLIER;

        $calculated['samor']['amount_real'] = $this->getSamorAmountReal($calculated['perimeter']);
        $calculated['samor']['full_weight'] = $this->getSamorWeight($calculated['samor']['amount_real']);
        $calculated['samor']['full_weight_ing_kg'] = $this->getSamorWeightInKG($calculated['samor']['full_weight']);
        $calculated['samor']['full_cost'] = $this->getSamorFullCost($calculated['samor']['amount_real']);

        $calculated['chandFixPipesSumm'] = $this->getChandFixPipesSumm($chandeliers, $fixtures, $pipes);

        $calculated['consumables']['bagets_cost'] = $calculated['bagets_cost'];
        $calculated['consumables']['dubgv_cost'] = $calculated['dubgv_cost'];
        $calculated['consumables']['samor_cost'] = $calculated['samor']['full_cost'];
        $calculated['consumables']['chandFixPipesSumm'] = $calculated['chandFixPipesSumm'];
        $calculated['consumables']['fuel'] = self::FUEL_FOR_ROAD_COST;
        $calculated['consumablesTotalSumm'] = array_sum($calculated['consumables']);
        $calculated['finalCost'] = array_sum([$calculated['consumablesTotalSumm'], $calculated['сeiling_squares_summ']]);

        return $calculated;
    }

    protected function getSides($request)
    {
        // для сторон и типа потолка следовало бы поставить валидатор
        $a = $request->post('st1') ?? 0;
        $b = $request->post('st2') ?? 0;
        $c = $request->post('st3') ?? 0;
        $d = $request->post('st4') ?? 0;

        return $sides = [$a, $b, $c, $d];
    }

    public function calculate(CalculateRequest $request)
    {
        $attributes = $request->validated();

        $natpotType = intval($request->post('natpot_type'));

        $chandeliers = $request->post('chandeliers') ?? 0;
        $fixtures = $request->post('fixtures') ?? 0;
        $pipes = $request->post('pipes') ?? 0;

        $this->sides = $this->getSides($request);

        $fixedNatpotData = $this->getFixedNatpots();
        $calculated = $this->calculateHandler($this->sides, $natpotType, $chandeliers, $fixtures, $pipes);

        //echo MGDebug::d($calculated);

        return view('natpot.index', ['calculated' => $calculated, 'fixedNatpotData' => $fixedNatpotData,
                'natpotType' => $natpotType, 'sides' => $this->sides, 'fuelCost' => $calculated['consumables']['fuel'],
                'chandeliers' => $chandeliers, 'fixtures' => $fixtures, 'pipes' => $pipes,
                'rusRoubleChar' => self::RUSS_ROUBLE_CHAR
            ]);
    }
}