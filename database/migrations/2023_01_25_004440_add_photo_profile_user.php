<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoProfileUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function (Blueprint $table) {

            $table->string('photo_profile')->after('face_card_two')->nullable();
            $table->string('type_blood')->after('photo_profile')->nullable();
            $table->date('birthday')->after('type_blood')->nullable();
            $table->timestamp('phone_verified_at')->nullable()->after('phone')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn('photo_profile');
//            $table->dropColumn('profession_id');
            $table->dropColumn('type_blood');
            $table->dropColumn('birthday');
            $table->dropColumn('phone_verified_at');

        });
    }
}
