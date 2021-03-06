<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\App\EventoTag
 *
 * @property int $id
 * @property int $evento_id
 * @property int $tag_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoTag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoTag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoTag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoTag whereEventoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoTag whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoTag whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Evento\Evento|null $evento
 */
class EventoTag extends Model
{
    protected $table = "evento_evento_tags";

    protected $fillable = [
      'evento_id', 'tag_id'
    ];

    public function evento(){
        return $this->hasOne('App\Models\Evento\Evento','id','evento_id');
    }

}
