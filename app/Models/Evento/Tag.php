<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\App\Tag
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @property string|null $img
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Tag whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Tag whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    protected $table = 'evento_tags';

    protected $fillable = [
        'name', 'color', 'img', 'user_id'
    ];
}
