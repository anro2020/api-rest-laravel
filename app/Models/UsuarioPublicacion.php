<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioPublicacion extends Model
{
    use HasFactory;

    protected $table = 'usuario_publicacion';

    protected $fillable = [
        'usuario_id',
        'publiacion_id'
    ];

    //relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function publicacion()
    {
        return $this->belongsTo(Publicacion::class);
    }
}
