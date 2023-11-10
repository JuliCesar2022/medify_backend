<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Customers extends Migration
{
    public function up()
    {

        Schema::create('customers', function (Blueprint $table) {

            $table->id();

            $table->string("name");
            $table->string("last_name")->nullable();
            $table->string("number_phone")->nullable();
            $table->string("email")->nullable();
            $table->text("desciption")->nullable();

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
        Schema::dropIfExists('customers');
    }
}
