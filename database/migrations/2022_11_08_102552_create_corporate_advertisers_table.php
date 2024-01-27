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
        Schema::create('corporate_advertisers', function (Blueprint $table) {
            $table->id('corpAdvID');
            $table->unsignedBigInteger('userID');
            $table->string('corpAdvName');
            $table->string('corpAdvAddress');
            $table->string('taxNumber');
            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade')->name('fk_corporate_advertiser_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('corporate_advertisers');
    }
};
