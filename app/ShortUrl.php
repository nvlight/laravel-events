<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShortUrl extends Model
{
    protected $fillable = [
        'description', 'longurl', 'shorturl', 'user_id'
    ];

}
