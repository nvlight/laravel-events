<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Evento\Tag
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @property string|null $img
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Tag whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Tag whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    protected $table = 'evento_tags';

    protected $fillable = [
        'name', 'color', 'img'
    ];
}
