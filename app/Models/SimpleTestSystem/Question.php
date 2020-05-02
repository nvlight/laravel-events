<?php

namespace App\Models\SimpleTestSystem;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SimpleTestSystem\Question
 *
 * @property int $id
 * @property int $parent_id
 * @property int $theme_id
 * @property int $number
 * @property int $type
 * @property string $description
 * @property int $description_type
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Question newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Question newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Question query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Question whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Question whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Question whereDescriptionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Question whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Question whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Question whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Question whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Question whereThemeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Question whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Question whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Question extends Model
{
    //
}
