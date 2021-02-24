<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\App\Category
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $slug
 * @property string|null $img
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Category whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int $user_id
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUserId($value)
 */
class Category extends Model
{
    protected $table = 'evento_categories';

    protected $fillable = [
        'name', 'parent_id', 'img', 'slug', 'user_id'
    ];

    protected $hidden = [
        'user_id',
    ];
}
