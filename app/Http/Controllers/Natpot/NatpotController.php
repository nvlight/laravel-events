<?php

namespace App\Http\Controllers\Natpot;

use App\Http\Controllers\SimpleTestSystem\DescriptionTypeController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MGDebug;

class NatpotController extends Controller
{
    public function index()
    {
        return view('natpot.index');
    }

    protected function number_in_range($a, $b, $number)
    {
        return ($a <= $number ) && ($number <= $b);
    }

    protected function squareTrapezoidBy4Sides($a, $b, $c, $d)
    {
        return (($a+$b)/2) * sqrt( $c*$c - pow( (pow( ($a-$b), 2) + $c*$c - $d*$d) / ( 2 * ($a - $b)) , 2 ) );
    }

    public function calculate(Request $request)
    {
        echo MGDebug::d($request->all());

        $a = $request->post('st1');
        $b = $request->post('st2');
        $c = $request->post('st3');
        $d = $request->post('st4');

        $natpotType = intval($request->post('natpot_type'));

        $maxWidth = max($a, $b, $c, $d);
        echo MGDebug::d($maxWidth, '$maxWidth');

        $perimeter = array_sum([$a, $b, $c, $d]);
        echo MGDebug::d($perimeter, '$perimeter');

        if ( ($a === $b) || ( ($a === $c) ** ($b===$d) ) ){
            $square = $a * $b;
        }else {
            $square = $this->squareTrapezoidBy4Sides($a, $b, $c, $d);
        }
        echo MGDebug::d($square, '$square');
        $ceilSquare = ceil($square);
        echo MGDebug::d($ceilSquare, '$ceilSquare');

        //
        $multiplier = 1;
        switch ($natpotType){
            case 1:
            case 2:
            case 3:
                echo MGDebug::d('type 1-3');
                if ( $this->number_in_range(0, 3.2, $maxWidth) ){
                    $multiplier = 130;
                }elseif( $this->number_in_range(3.2, 3.6, $maxWidth) ){
                    $multiplier = 140;
                } elseif( $this->number_in_range(3.6, 4, $maxWidth) ){
                    $multiplier = 170;
                }elseif( $this->number_in_range(4, 5, $maxWidth) ){
                    $multiplier = 170;
                }
                break;
            case 4:
            case 5:
            case 6:
            echo MGDebug::d('type 4-6');
                if ( $this->number_in_range(0, 3.2, $maxWidth) ){
                    $multiplier = 175;
                } elseif( $this->number_in_range(3.2, 3.6, $maxWidth) ){
                    $multiplier = 200;
                } elseif( $this->number_in_range(3.6, 4, $maxWidth) ){
                    $multiplier = 240;
                }elseif( $this->number_in_range(4, 5, $maxWidth) ){
                    $multiplier = 240;
                }
                break;
            case 7:
                if ( $this->number_in_range(0, 3.2, $maxWidth) ){
                    $multiplier = 300;
                }
                break;
            case 8:
                if ( $this->number_in_range(0, 3.2, $maxWidth) ){
                    $multiplier = 330;
                }
                break;
            case 9:
                if ( $this->number_in_range(0, 3.2, $maxWidth) ){
                    $multiplier = 400;
                }
                break;
            default:
                $multiplier = 1;
        }

        echo MGDebug::d($multiplier,'',2);

        die;

        return view('natpot.index');
    }
}
