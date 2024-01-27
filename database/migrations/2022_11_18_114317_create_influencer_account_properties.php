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
        Schema::create('influencer_account_properties', function (Blueprint $table) {
            $table->id('infAccPropID');
            $table->unsignedBigInteger('infID');
            $table->unsignedBigInteger('platformID');
            $table->string('platformUserName');
            $table->integer('followerCount');
            $table->integer('followingCount');
            $table->integer('mediaCount');
            $table->integer('avarageLikeCount');
            $table->integer('avarageViewCount');
            $table->integer('storyViewCount')->nullable();
            $table->integer('reachedAccountCount')->nullable();
            $table->integer('enagagedAccountCount')->nullable();
            $table->integer('saveCount')->nullable();
            $table->integer('shareCount')->nullable();
            $table->boolean("socialVerify")->default(false);

            $table->foreign('infID')->references('infID')->on('influencers')->onDelete('cascade')->name('fk_influencer_account_property_influencer');
            $table->foreign('platformID')->references('platformID')->on('platforms')->onDelete('cascade')->name('fk_influencer_account_property_platform');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('influencer_account_properties');
    }
};
