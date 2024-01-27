<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_temporary_verification_codes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userID');
            $table->integer('code');
            $table->timestamp('expire_date');
            $table->timestamps();
            $table->foreign('user_id')->references('userID')->on('users')->onDelete('cascade')->name('fk_user_verifications_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_temporary_verifications_code');
    }
};
