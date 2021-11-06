<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Evento\EventoTagValue
 *
 * @property int $id
 * @property int $evento_evento_tags_id
 * @property int $value
 * @property string|null $caption
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EventoTagValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventoTagValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EventoTagValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|EventoTagValue whereCaption($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventoTagValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventoTagValue whereEventoEventoTagsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventoTagValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventoTagValue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EventoTagValue whereValue($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Evento\EventoTag|null $tag
 */
class EventoTagValue extends Model
{
    protected $table = "evento_evento_tag_values";

    protected $fillable = [
        'evento_evento_tags_id', 'value', 'caption'
    ];

    public function tag(){
        return $this->hasOne('App\Models\Evento\EventoTag','id','evento_evento_tags_id');
    }

}
