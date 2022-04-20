<?php

namespace Database\Factories;

use App\Models\Publicacion;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicacionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'pub_titulo' => $this->faker->word(),
            'pub_descripcion' => $this->faker->text($maxNbChars = 200),
            'pub_activa' => $this->faker->randomElement([Publicacion::PUBLICACION_ACTIVA, Publicacion::PUBLICACION_INACTIVA])
        ];
    }
}
