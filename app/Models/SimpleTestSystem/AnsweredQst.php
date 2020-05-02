<?php

namespace App\Models\SimpleTestSystem;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SimpleTestSystem\AnsweredQst
 *
 * @property int $id
 * @property int $user_id
 * @property int $prepared_qst_id
 * @property int $question_id
 * @property mixed $answer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\AnsweredQst newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\AnsweredQst newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\AnsweredQst query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\AnsweredQst whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\AnsweredQst whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\AnsweredQst whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\AnsweredQst wherePreparedQstId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\AnsweredQst whereQuestionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\AnsweredQst whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\AnsweredQst whereUserId($value)
 * @mixin \Eloquent
 */
class AnsweredQst extends Model
{
    //
}
