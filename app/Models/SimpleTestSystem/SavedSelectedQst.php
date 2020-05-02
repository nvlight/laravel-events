<?php

namespace App\Models\SimpleTestSystem;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SimpleTestSystem\SavedSelectedQst
 *
 * @property int $id
 * @property int $test_number
 * @property int $shedule_id
 * @property int $test_id
 * @property int $selected_qsts_id
 * @property int $qsts_number
 * @property string $qsts_answer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\SavedSelectedQst newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\SavedSelectedQst newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\SavedSelectedQst query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\SavedSelectedQst whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\SavedSelectedQst whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\SavedSelectedQst whereQstsAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\SavedSelectedQst whereQstsNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\SavedSelectedQst whereSelectedQstsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\SavedSelectedQst whereSheduleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\SavedSelectedQst whereTestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\SavedSelectedQst whereTestNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\SavedSelectedQst whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SavedSelectedQst extends Model
{
    //
}
