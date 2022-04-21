<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\ApiController;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends ApiController
{

    public function MostrarUsuarios()
    {
        $usuarios = Usuario::all();

        return $this->showAll($usuarios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CrearUsuario(Request $request)
    {
        //Validacion de datos
        $reglas=[
            'usu_nombre' => 'required',
            'usu_correo' => 'required|email|unique:usuarios',
            'usu_contrasenia' => 'required|min:6',
            'confirmarContrasenia' => 'required|same:usu_contrasenia'
        ];

        $this->validate($request, $reglas);

        //Recibir peticion
        $datos = $request->all();
        $datos['usu_contrasenia'] = bcrypt($request->usu_contrasenia);
        $datos['usu_verificado'] = Usuario::USUARIO_NO_VERIFICADO;
        $datos['usu_token_verificacion'] = Usuario::generarTokenVerficacion();
        $datos['usu_admin'] = Usuario::USUARIO_REGULAR;
        $datos['usu_activo'] = Usuario::USUARIO_DESACTIVADO;

        //Realizar peticion
        $usuario = Usuario::create($datos);

        return $this->showOne($usuario, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function MostrarUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);

        return $this->showOne($usuario);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function EditarUsuario(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $reglas = [
            'usu_correo' => 'email|unique:usuarios,usu_correo,' . $usuario->id,
            'usu_contrasenia' => 'min:6',
            'confirmarContrasenia' => 'same:usu_contrasenia',
            'usu_admin' => 'in:' . Usuario::USUARIO_ADMINISTRADOR . ',' . Usuario::USUARIO_REGULAR,
            'usu_activo' => 'in:' . Usuario::USUARIO_ACTIVADO . ',' . Usuario::USUARIO_DESACTIVADO
        ];

        $this->validate($request, $reglas);

        if ($request->has('usu_nombre'))
        {
            $usuario->usu_nombre = $request->usu_nombre;
        }

        if ($request->has('usu_correo') && $usuario->usu_correo != $request->usu_correo)
        {
            $usuario->usu_verificado = Usuario::USUARIO_NO_VERIFICADO;
            $usuario->usu_token_verificacion = Usuario::generarTokenVerficacion();
            $usuario->usu_correo = $request->usu_correo;
        }

        if ($request->has('usu_contrasenia'))
        {
            $usuario->usu_contrasenia = bcrypt($request->usu_contrasenia);
        }

        if ($request->has('usu_admin'))
        {
            if(!$usuario->esVerificado())
            {
                return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su valor de administrador.', 409);
            }

            $usuario->usu_admin = $request->usu_admin;
        }

        if ($request->has('usu_activo'))
        {
            if(!$usuario->esActivo())
            {
                return $this->errorResponse('Unicamente los usuarios administradores pueden activar usuarios.', 409);
            }

            $usuario->usu_activo = $request->usu_activo;
        }

        if (!$usuario->isDirty())
        {
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar.', 422);   
        }

        $usuario->save();

        return $this->showOne($usuario);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DesactivarUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->usu_activo = Usuario::USUARIO_DESACTIVADO;

        $usuario->save();

        return $this->showOne($usuario, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function EliminarUsuario($id)
    {
        $usuario = Usuario::findOrFail($id);

        $usuario->delete($id);

        return $this->showOne($usuario, 200);

    }
}
