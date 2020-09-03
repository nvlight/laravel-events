<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\App\Evento
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Evento newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Evento newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\Evento query()
 * @mixin \Eloquent
 */
class Evento extends Model
{
    protected $table = 'evento_eventos';

    protected $fillable = [
        'user_id', 'description', 'date'
    ];
}
