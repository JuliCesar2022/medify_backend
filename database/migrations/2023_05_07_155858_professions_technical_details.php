<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProfessionsTechnicalDetails extends Migration
{
   static $tableName = "professions_technical_details";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable(self::$tableName)) {

            Schema::create(self::$tableName, function (Blueprint $table) {

                $table->id();
                $table->unsignedBigInteger("technical_id");
                $table->string("profession_id");

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
//        Schema::dropIfExists(self::$tableName);
    }
}
