<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Medicamentos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('medicamentos', function (Blueprint $table) {
            $table->id();
            $table->string('medicamento');
            $table->string('tipomedicamento');
            $table->string('dosis');
            $table->unsignedBigInteger('usuario_id'); // Asume que usas un tipo 'bigInteger' para el 'id' de usuarios
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->string('frecuencia');
            $table->date('iniciotratamiento');
            $table->date('fintratameinto');
            $table->boolean('recordar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
