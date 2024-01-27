<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enum\UserTypes;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('userID');
            $table->string('nameSurname');
            $table->string('password')->nullable();
            $table->string('email')->unique();
            $table->string("profilePhoto")->nullable();
            $table->enum("userType", UserTypes::cases())->default(UserTypes::User);
            $table->float("balance", 10, 2)->nullable();


            $table->foreign('userID')->references('userID')->on('user_verifications')->onDelete('cascade')->name('fk_users_user_verificiations');
            $table->foreign('userID')
                  ->references('userID')
                  ->on('user_temporary_verifications_code')
                  ->onDelete('cascade')
                  ->name('fk_users_user_temporary_verifications_code');
            $table->foreign('userID')->references('userID')->on('influencers')->onDelete('cascade')->name('fk_users_influencers');
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');

    }
};
