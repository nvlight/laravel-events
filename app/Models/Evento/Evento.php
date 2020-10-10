<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    public function getDateAttribute() {
        return $this->attributes['date'] = (new Carbon($this->attributes['date']))->format('d.m.Y');
    }
}
