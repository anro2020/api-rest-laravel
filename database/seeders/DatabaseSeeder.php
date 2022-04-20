<?php

namespace Database\Seeders;

use App\Models\Publicacion;
use App\Models\Usuario;
use App\Models\UsuarioPublicacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Usuario::truncate();
        //Publicacion::truncate();
        //UsuarioPublicacion::truncate();

        $usuario = Usuario::factory()->count(20)->create();
        $publicacion = Publicacion::factory()->count(20)->create();
        $usuario_publicacion = UsuarioPublicacion::factory()->count(20)->create();
    }
}
