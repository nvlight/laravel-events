<?php

namespace App\Models\ShortUrl;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

/**
 * App\Models\ShortUrl\ShortUrlsCategory
 *
 * @property int $id
 * @property int $user_id
 * @property int $parent_id
 * @property string $name
 * @property string $slug
 * @property string|null $img
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrlsCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrlsCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrlsCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrlsCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrlsCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrlsCategory whereImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrlsCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrlsCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrlsCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrlsCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ShortUrlsCategory whereUserId($value)
 * @mixin \Eloquent
 */
class ShortUrlsCategory extends Model
{
    // use NodeTrait; посмотрим потом - пригодится он или же нет.

    protected $table = 'shorturl_categories';

    protected $fillable = [
        'user_id', 'parent_id', 'name', 'slug', 'img'
    ];
}
