<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $contrasenia;

        return [
            'usu_nombre' => $this->faker->name(),
            'usu_correo' => $this->faker->unique()->safeEmail(),
            'usu_contrasenia' => $contrasenia ?: $contrasenia = bcrypt('secreta'),
            'usu_verificado' => $verificado = $this-> faker->randomElement([Usuario::USUARIO_VERIFICADO, Usuario::USUARIO_NO_VERIFICADO]),
            'usu_activo' => $this->faker->randomElement([Usuario::USUARIO_ACTIVO, Usuario::USUARIO_INACTIVO]),
            'usu_token_verificacion' => $verificado == Usuario::USUARIO_VERIFICADO ? null : Usuario::generarTokenVerficacion(),
            'usu_admin' => $this->faker->randomElement([Usuario::USUARIO_ADMINISTRADOR, Usuario::USUARIO_REGULAR])
        ];
    }
}
