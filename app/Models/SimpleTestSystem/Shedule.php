<?php

namespace App\Models\SimpleTestSystem;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SimpleTestSystem\Shedule
 *
 * @property int $id
 * @property string $name
 * @property string $test_started_at
 * @property int $duration
 * @property int $selected_qsts_number
 * @property int $test_id
 * @property int $qsts_count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Shedule newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Shedule newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Shedule query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Shedule whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Shedule whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Shedule whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Shedule whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Shedule whereQstsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Shedule whereSelectedQstsNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Shedule whereTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Shedule whereTestStartedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Shedule whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Shedule extends Model
{
    //
}
