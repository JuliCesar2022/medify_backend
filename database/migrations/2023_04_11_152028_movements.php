<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Movements extends Migration
{
    protected $connection ='mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('movements')) {

            Schema::create('movements', function (Blueprint $table) {

                $table->id();

                $table->unsignedBigInteger("technical_id");
                $table->string("current_balance");
                $table->string("amount");
                $table->string("table_ref");
                $table->string("type")->comment("IN - OUT");
                $table->date("date");

                $table->timestamps();

            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::dropIfExists('movements');
    }
}
