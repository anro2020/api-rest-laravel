<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Usuario;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('usu_nombre');
            $table->string('usu_correo')->unique();
            $table->string('usu_contrasenia');
            $table->string('usu_verificado')->default(Usuario::USUARIO_NO_VERIFICADO);
            $table->string('usu_token_verificacion')->nullable();
            $table->string('usu_llaveUnica')->nullable();
            $table->string('usu_admin')->default(Usuario::USUARIO_REGULAR);;
            $table->string('usu_activo')->default(Usuario::USUARIO_DESACTIVADO);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
