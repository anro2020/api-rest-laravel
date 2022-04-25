<?php

namespace App\Providers;

use App\Mail\UsuarioCambioCorreo;
use App\Mail\UsuarioCreado as MailUsuarioCreado;
use App\Models\Usuario;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Usuario::created(function($usuario) {   
            Mail::to('19170163@uttcampus.edu.mx')->send(new MailUsuarioCreado($usuario));
        });

        Usuario::updated(function ($usuario) {
            if($usuario->isDirty('usu_correo'))
            {
                Mail::to('19170163@uttcampus.edu.mx')->send(new UsuarioCambioCorreo($usuario));
            }
        });
    }
}
