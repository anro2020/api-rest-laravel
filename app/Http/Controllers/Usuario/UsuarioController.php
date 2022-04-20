<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

    public function MostrarUsuarios()
    {
        $usuarios = Usuario::all();

        return response()->json(['datos' => $usuarios], 200);
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

        return response()->json(['datos' => $usuario], 201);
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

        return response()->json(["datos" => $usuario], 200);
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
                return response()->json(['error' => 'Unicamente los usuarios verificados pueden cambiar su valor de administrador.', 'codigo' => 409], 409);
            }

            $usuario->usu_admin = $request->usu_admin;
        }

        if ($request->has('usu_activo'))
        {
            if(!$usuario->esActivo())
            {
                return response()->json(['error' => 'Unicamente los usuarios administradores pueden activar usuarios.', 'codigo' => 409], 409);
            }

            $usuario->usu_activo = $request->usu_activo;
        }

        if (!$usuario->isDirty())
        {
            return response()->json(['error' => 'Se debe especificar al menos un valor diferente para actualizar.', 'codigo' => 422], 422);   
        }

        $usuario->save();

        return response()->json(['datos' => $usuario], 200);
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

        return response()->json(['datos', $usuario], 200);

        /* Eliminar usuario
           $usuario->delete();
        */

    }
}
