<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = "evento_attachments";

    protected $fillable = [
        'user_id', 'evento_id', 'file', 'originalname', 'mimetype', 'size'
    ];
}
