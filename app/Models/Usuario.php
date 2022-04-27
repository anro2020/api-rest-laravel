<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Usuario extends Model
{
    use HasFactory, SoftDeletes;

    const USUARIO_ACTIVADO = '1';
    const USUARIO_DESACTIVADO = '0';

    const USUARIO_NO_VERIFICADO ='0';
    const USUARIO_VERIFICADO = '1';

    const USUARIO_ADMINISTRADOR = 'true';
    const USUARIO_REGULAR = 'false';

    protected $table = 'usuarios';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'usu_nombre',
        'usu_correo',
        'usu_contrasenia',
        //'usu_admin',
        //'usu_verificado',
        //'usu_token_verificacion',
        //'usu_activo'
        
    ];

    protected $hidden = [
        'usu_contrasenia',
        'usu_verificado',
        'usu_token_verificacion',
        'usu_activo'
        //'usu_token_verificacion',
    ];

    //Mutadores, antes de ser insertado a la base de datos
    public function setAtributoNombre($valor)
    {
        $this->attributes['usu_nombre'] = strtolower($valor);
    }
    public function setAtributoCorreo($valor)
    {
        $this->attributes['usu_correo'] = strtolower($valor);
    }

    //Accesor, despues de ser insertado a la base de datos
    public function getAtributoNombre($valor)
    {
        return ucwords($valor);
    }

    //----------------------//
    public function esActivo()
    {
        return $this->usu_activo == Usuario::USUARIO_ACTIVADO;
    }
    public function esVerificado()
    {
        return $this->usu_verificado == Usuario::USUARIO_VERIFICADO;
    }
    public function esAdministrador()
    {
        return $this->usu_admin == Usuario::USUARIO_ADMINISTRADOR;
    }

    //Genera token de verficacion
    public static function generarTokenVerficacion()
    {
        return Str::random(40);
    }
}
