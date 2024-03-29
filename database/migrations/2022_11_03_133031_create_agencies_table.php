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
        Schema::create('agencies', function (Blueprint $table) {
            $table->id('agencyID');
            $table->unsignedBigInteger('userID');
            $table->string('agencyName');
            $table->string('agencyAddress');
            $table->string('taxNumber');
            $table->timestamps();

            $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade')->name('fk_agencies_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agencies');
    }
};
