<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Type
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $color
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Type newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Type newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Type query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Type whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Type whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Type whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Type whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Type whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Type whereUserId($value)
 * @mixin \Eloquent
 */
class Type extends Model
{
    //
    protected $fillable = [
        'name', 'color', 'user_id'
    ];

}
