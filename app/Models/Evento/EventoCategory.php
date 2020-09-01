<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\App\EventoCategory
 *
 * @property int $id
 * @property int $evento_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\EventoCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\EventoCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\EventoCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\EventoCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\EventoCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\EventoCategory whereEventoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\EventoCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\App\EventoCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EventoCategory extends Model
{
    protected $table = "evento_evento_categories";
}
