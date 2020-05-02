<?php

namespace App\Models\SimpleTestSystem;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SimpleTestSystem\TestCategory
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $img
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\TestCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\TestCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\TestCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\TestCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\TestCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\TestCategory whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\TestCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\TestCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SimpleTestSystem\TestCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TestCategory extends Model
{
    //
}
