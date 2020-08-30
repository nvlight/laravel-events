<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Evento\EventoCategory
 *
 * @property int $id
 * @property int $evento_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoCategory whereEventoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Evento\EventoCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventoCategory extends Model
{
    protected $table = "evento_evento_categories";
}
