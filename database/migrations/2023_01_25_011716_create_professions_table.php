<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfessionsTable extends Migration
{

    protected $connection ='mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('professions')) {

            Schema::create('professions', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug_name');
                $table->boolean('status')->default(true);
                $table->softDeletes();
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
//        Schema::dropIfExists('professions');
    }
}
