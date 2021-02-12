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
 * @property int $id
 * @property int $user_id
 * @property string $description
 * @property int $status
 * @property string $date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Evento whereUserId($value)
 */
class Evento extends Model
{
    protected $table = 'evento_eventos';

    protected $hidden = ['user_id'];

    protected $fillable = [
        'user_id', 'description', 'date'
    ];

    protected $casts = [
        //'data' => 'array',
    ];

//    public function getDateAttribute() {
//        return $this->attributes['date'] = (new Carbon($this->attributes['date']))->format('d.m.Y');
//    }

}
