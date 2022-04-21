<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Publicacion extends Model
{
    use HasFactory, SoftDeletes;

    const PUBLICACION_ACTIVA = '1';
    const PUBLICACION_INACTIVA = '0';

    protected $table = 'publicaciones';

    protected $dates = ['deleted_at'];
    
    protected $fillable = [
        'pub_titulo',
        'pub_descripcion',
        'pub_activa'
    ];

    public function publicacionActiva()
    {
        return $this-> pub_activa == Publicacion::PUBLICACION_ACTIVA;
    }
}