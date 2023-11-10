<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Address extends Migration
{
    public function up()
    {

        Schema::create('address', function (Blueprint $table) {

            $table->id();

            $table->string("name")->nullable();
            $table->string("direccion");
            $table->string("referencia")->nullable();
            $table->string("description")->nullable();

            $table->double("latitude")->nullable();
            $table->double("longitude")->nullable();

            $table->unsignedBigInteger("customers_id")->nullable();
            $table->unsignedBigInteger("municipality_id")->nullable();
            $table->unsignedBigInteger("department_id")->nullable();
            $table->unsignedBigInteger("country_id")->nullable();
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
        Schema::dropIfExists('address');
    }
}
