<?php

namespace App\Models\Event;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Category
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Category whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Event\Category whereUserId($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    //
    protected $fillable = [
      'name', 'user_id'
    ];

}
