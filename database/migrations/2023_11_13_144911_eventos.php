<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Eventos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //

        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_evento');
            $table->date('fecha');
            $table->time('hora');
            $table->unsignedBigInteger('usuario_id'); // Asume que usas un tipo 'bigInteger' para el 'id' de usuarios
            $table->foreign('usuario_id')->references('id')->on('users');
            $table->integer('item_id'); // Asume que usas un tipo 'bigInteger' para el 'id' de usuarios
            $table->string('tabla_referencia'); // Asume que usas un tipo 'bigInteger' para el 'id' de usuarios
          
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
