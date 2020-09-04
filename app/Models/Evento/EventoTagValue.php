<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Model;

class EventoTagValue extends Model
{
    protected $table = "evento_evento_tag_values";

    protected $fillable = [
        'evento_evento_tags_id', 'value', 'caption'
    ];
}
