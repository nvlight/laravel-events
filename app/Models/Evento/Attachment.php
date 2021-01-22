<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Evento\Attachment
 *
 * @property int $id
 * @property int $user_id
 * @property int $evento_id
 * @property string $file
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $originalname
 * @property string $mimetype
 * @property int $size
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereEventoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereMimetype($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereOriginalname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereUserId($value)
 * @mixin \Eloquent
 */
class Attachment extends Model
{
    protected $table = "evento_attachments";

    protected $fillable = [
        'user_id', 'evento_id', 'file', 'originalname', 'mimetype', 'size'
    ];
}
