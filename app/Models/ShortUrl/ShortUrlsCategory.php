<?php

namespace App\Models\ShortUrl;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class ShortUrlsCategory extends Model
{
    // use NodeTrait; посмотрим потом - пригодится он или же нет.

    protected $table = 'shorturl_categories';

    protected $fillable = [
        'user_id', 'parent_id', 'name', 'slug', 'img'
    ];
}
