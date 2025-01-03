<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombre',
        'descripcion',
        'detalles',
        'fecha',
        'user_id',
        'premium'
    ];

    public function FotosPorEvento(){
        return $this->hasMany(Photo::class);
    }
}
