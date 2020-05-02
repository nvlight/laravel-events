<?php

namespace App\models\simpleTestSystem;

use Illuminate\Database\Eloquent\Model;

/**
 * App\models\simpleTestSystem\TestResult
 *
 * @property int $id
 * @property int $test_number
 * @property int $shedule_id
 * @property int $test_id
 * @property int $selected_qsts_id
 * @property string $test_started_at
 * @property string $test_ended_at
 * @property int $test_status
 * @property int $ball
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult whereBall($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult whereSelectedQstsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult whereSheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult whereTestEndedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult whereTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult whereTestNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult whereTestStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult whereTestStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\models\simpleTestSystem\TestResult whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TestResult extends Model
{
    //
}
