<?php

namespace App\Models\ShortUrl;

use Illuminate\Database\Eloquent\Model;

class ShortUrlsCategory extends Model
{
    protected $table = 'shorturl_categories';

    protected $fillable = [
        'user_id', 'parent_id', 'name', 'slug', 'img'
    ];
}
