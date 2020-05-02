<?php

namespace App\Models\ShortUrl;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ShortUrl\ShortUrl
 *
 * @property int $id
 * @property int $user_id
 * @property int $category_id
 * @property string $longurl
 * @property string $shorturl
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl\ShortUrl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl\ShortUrl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl\ShortUrl query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl\ShortUrl whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl\ShortUrl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl\ShortUrl whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl\ShortUrl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl\ShortUrl whereLongurl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl\ShortUrl whereShorturl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl\ShortUrl whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ShortUrl\ShortUrl whereUserId($value)
 * @mixin \Eloquent
 */
class ShortUrl extends Model
{
    protected $fillable = [
        'description', 'longurl', 'shorturl', 'user_id'
    ];

}
