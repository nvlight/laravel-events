<?php

namespace App\Models\Document;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Document\Document
 *
 * @property int $id
 * @property int $user_id
 * @property string $filename
 * @property string $realname
 * @property string $mime
 * @property int $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document\Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document\Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document\Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document\Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document\Document whereFilename($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document\Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document\Document whereMime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document\Document whereRealname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document\Document whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document\Document whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Document\Document whereUserId($value)
 * @mixin \Eloquent
 */
class Document extends Model
{
    protected $guarded = [];
}
