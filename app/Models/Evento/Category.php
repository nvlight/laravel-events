<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Evento\Category
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property string $slug
 * @property string|null $img
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Category whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    protected $table = 'evento_categories';

    protected $fillable = [
        'name', 'parent_id', 'img', 'slug', 'user_id'
    ];
}
