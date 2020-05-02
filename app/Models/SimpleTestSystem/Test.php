<?php

namespace App\Models\SimpleTestSystem;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SimpleTestSystem\Test
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property mixed|null $author_ids
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Test newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Test newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Test query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Test whereAuthorIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Test whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Test whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Test whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Test whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\Test whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Test extends Model
{
    //
}
