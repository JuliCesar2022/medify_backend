<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Briefcase extends Migration
{
    protected $connection ='mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('briefcases')) {

            Schema::create('briefcases', function (Blueprint $table) {

                $table->id();

                $table->unsignedBigInteger("technical_id");
                $table->string("current_amount")->nullable();
                $table->date("date")->nullable();

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
//        Schema::dropIfExists('briefcases');
    }
}
