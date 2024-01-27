<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_verifications', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('userID')->unsigned();
            $table->string('phoneNumber')->nullable();
            $table->boolean("phoneVerify")->default(false);
            $table->timestamp('phoneVerifyDate')->nullable();
            $table->timestamp('phoneLastCodeSendDate')->nullable();
            $table->boolean("eMailVerify")->default(false);
            $table->timestamp('eMailLastCodeSendDate')->nullable();
            $table->timestamp('eMailVerifyDate')->nullable();
            $table->timestamp('lastLoginDate')->nullable();
            $table->timestamp('registerDate')->nullable();
            $table->string('googleId')->nullable();
            $table->string('facebookId')->nullable();
            $table->string('twitterId')->nullable();
            $table->string('appleId')->nullable();
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
        Schema::dropIfExists('user_contact_information');
    }
};
