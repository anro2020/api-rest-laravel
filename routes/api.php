<?php

use App\Http\Controllers\Usuario\UsuarioController;
use App\Http\Controllers\UsuarioPublicacion\UsuarioPublicacionController;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::controller(UsuarioController::class)->group(function (){
    Route::get('/Usuarios', 'MostrarUsuarios');
    Route::get('/Usuario/{id}',  'MostrarUsuario');
    Route::post('/NuevoUsuario', 'CrearUsuario');
    Route::put('/EditarUsuario/{id}',  'EditarUsuario');
    Route::put('/DesactivarUsuario/{id}', 'DesactivarUsuario');
    Route::delete('/EliminarUsuario/{id}', 'EliminarUsuario');
});

Route::controller(UsuarioPublicacionController::class)->group(function (){
  Route::get('/Publicaciones', 'MostrarPublicaciones');
});
