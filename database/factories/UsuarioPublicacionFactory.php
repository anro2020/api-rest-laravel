<?php

namespace Database\Factories;

use App\Models\Publicacion;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioPublicacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'usuario_id' => Usuario::all()->random()->id,
            'publicacion_id' => Publicacion::all()->random()->id 
        ];
    }
}
