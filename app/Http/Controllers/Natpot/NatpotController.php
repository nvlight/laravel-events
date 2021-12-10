<?php

namespace App\Http\Controllers\Natpot;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MGDebug;

class NatpotController extends Controller
{
    CONST MAT_SAT_GLANEC__WHITE_32 = 130;
    CONST MAT_SAT_GLANEC__WHITE_36 = 140;
    CONST MAT_SAT_GLANEC__WHITE_4_5 = 170;
    CONST MAT_SAT_GLANEC__COLORED_32 = 175;
    CONST MAT_SAT_GLANEC__COLORED_36 = 200;
    CONST MAT_SAT_GLANEC__COLORED_4_5 = 240;
    CONST TEXTURED = 300; // фактурные
    CONST SPARKS = 330;   // искры
    CONST CLOUDS = 400;   // облака

    CONST BAGET_STEP = 0.18;     // with 2 dots
    CONST BAGET_ONE_COST = 25;   // kv.m.
    CONST BAGET_ONE_LENGTH = 2;  // m

    public function index()
    {
        $fixedNatpotData = $this->getFixedNatpots();
        $natpotType = 0;

        return view('natpot.index', ['fixedNatpotData' => $fixedNatpotData, 'natpotType' => $natpotType]);
    }

    protected function number_in_range($a, $b, $number)
    {
        return ($a <= $number ) && ($number <= $b);
    }

    protected function squareTrapezoidBy4Sides($a, $b, $c, $d)
    {
        return (($a+$b)/2) * sqrt( $c*$c - pow( (pow( ($a-$b), 2) + $c*$c - $d*$d) / ( 2 * ($a - $b)) , 2 ) );
    }

    protected function getMaxWidth($a, $b, $c, $d)
    {
        return max($a, $b, $c, $d);
    }

    protected function getPerimeter($a, $b, $c, $d)
    {
        return array_sum([$a, $b, $c, $d]);
    }

    protected function getSquare($a, $b, $c, $d)
    {
        if ( ($a === $b) || ( ($a === $c) ** ($b===$d) ) ){
            return $a * $b;
        }

        return $this->squareTrapezoidBy4Sides($a, $b, $c, $d);
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
        return ceil($perimeter / self::BAGET_ONE_LENGTH);
    }

    protected function getMultiplier($natpotType, $maxWidth)
    {
        //
        $multiplier = 1;
        switch ($natpotType){
            case 1:
            case 2:
            case 3:
                $calculated['1-3'] = 0;
                if ( $this->number_in_range(0, 3.2, $maxWidth) ){
                    $multiplier = self::MAT_SAT_GLANEC__WHITE_32;   //130;
                }elseif( $this->number_in_range(3.2, 3.6, $maxWidth) ){
                    $multiplier = self::MAT_SAT_GLANEC__WHITE_36;  // 140;
                } elseif( $this->number_in_range(3.6, 4, $maxWidth) ){
                    $multiplier = self::MAT_SAT_GLANEC__WHITE_4_5; // 170;
                }elseif( $this->number_in_range(4, 5, $maxWidth) ){
                    $multiplier = self::MAT_SAT_GLANEC__WHITE_4_5; // 170;
                }
                break;
            case 4:
            case 5:
            case 6:
                $calculated['4-6'] = 0;
                if ( $this->number_in_range(0, 3.2, $maxWidth) ){
                    $multiplier = self::MAT_SAT_GLANEC__COLORED_32; //175;
                } elseif( $this->number_in_range(3.2, 3.6, $maxWidth) ){
                    $multiplier = self::MAT_SAT_GLANEC__COLORED_36; //200;
                } elseif( $this->number_in_range(3.6, 4, $maxWidth) ){
                    $multiplier = self::MAT_SAT_GLANEC__COLORED_4_5; //240;
                }elseif( $this->number_in_range(4, 5, $maxWidth) ){
                    $multiplier = self::MAT_SAT_GLANEC__COLORED_4_5; //240;
                }
                break;
            case 7:
                $calculated['7'] = 0;
                if ( $this->number_in_range(0, 3.2, $maxWidth) ){
                    $multiplier = self::TEXTURED;
                }
                break;
            case 8:
                $calculated['8'] = 0;
                if ( $this->number_in_range(0, 3.2, $maxWidth) ){
                    $multiplier = self::SPARKS;
                }
                break;
            case 9:
                $calculated['9'] = 0;
                if ( $this->number_in_range(0, 3.2, $maxWidth) ){
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
//        <optgroup label="Белый. Ширина до 5 метров">
//            <option value="1">Матовый</option>
//            <option value="2">Сатиновый</option>
//            <option value="3">Глянцевый</option>
//        </optgroup>
//        <optgroup label="Цветной. Ширина до 5 метров">
//            <option value="4">Матовый</option>
//            <option value="5">Сатиновый</option>
//            <option value="6">Глянцевый</option>
//        </optgroup>
//        <option value="7">Фактурные (ширина до 3.2 метра)</option>
//        <option value="8">Искры (ширина до 3.2 метра)</option>
//        <option value="9">Облака (ширина до 3.2 метра)</option>
//        <option value="10"><strong>Дескор</strong></option>
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

    public function calculate(Request $request)
    {
        $a = $request->post('st1');
        $b = $request->post('st2');
        $c = $request->post('st3');
        $d = $request->post('st4');

        $calculated = [];

        $natpotType = intval($request->post('natpot_type'));

        $fixedNatpotData = $this->getFixedNatpots();

        $calculated['maxWidth'] = $this->getMaxWidth($a, $b, $c, $d);
        $calculated['perimeter'] = $this->getPerimeter($a,$b,$c,$d);
        $calculated['square'] = $this->getSquare($a,$b,$c,$d);
        $calculated['square_ceil'] = $this->getCeilSquare($calculated['square']);
        $calculated['bagets_amount'] = $this->getBagetsAmount($calculated['perimeter']);
        $calculated['bagets_cost'] = $this->getBagetsCost($calculated['bagets_amount']);
        $calculated['multiplier'] = $this->getMultiplier($natpotType, $calculated['maxWidth']);

        //echo MGDebug::d($calculated);

        return view('natpot.index', ['calculated' => $calculated, 'fixedNatpotData' => $fixedNatpotData,
                'natpotType' => $natpotType,
            ]);
    }
}