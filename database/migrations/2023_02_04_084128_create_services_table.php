<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    protected $connection ='mongodb';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        if (!Schema::hasTable('services')) {

            Schema::create('services', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('client_id');
                $table->string('technical_id');
                $table->string('profession_id');

                $table->unsignedInteger('amount');
                $table->enum('status', ['CREATED','ASSIGNED', 'FINISHED', 'DECLINED', 'ERROR']);

                $table->date('scheduled_date')->nullable();

                $table->string('scheduled_time')->nullable();
                $table->date('start_date')->nullable();
                $table->date('last_update_status')->nullable();
                $table->date('finish_date')->nullable();

                $table->boolean('is_public')->nullable();

                //init adress data
                $table->string("district");
                $table->string("direccion");
                $table->string("referencia")->nullable();

                $table->double("latitude")->nullable();
                $table->double("longitude")->nullable();

                $table->unsignedBigInteger("municipality_id")->nullable();
                $table->unsignedBigInteger("department_id")->nullable();
                $table->unsignedBigInteger("country_id")->nullable();
                //end adress data

                $table->text("service_title")->nullable();
                $table->text("service_description")->nullable();
                $table->text("public_description")->nullable();

                $table->enum('cancelled', ['CLIENT', 'TECNICO', 'SOPORT', 'OTHER'])->nullable();
                $table->text('cancellation_reason')->nullable();

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
//        Schema::dropIfExists('services');
    }
}
