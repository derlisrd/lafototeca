<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;
    protected $fillable = [
        'event_id',
        'titulo',
        'url_b',
        'url_q',
        'url_m',
        'name',
        'host',
        'extension'
    ];
}
