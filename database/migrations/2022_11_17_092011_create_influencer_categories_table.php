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
            Schema::create('influencer_categories', function (Blueprint $table) {

                $table->unsignedBigInteger('influencer_id');
                $table->unsignedBigInteger('category_id')->unsigned();

                $table->primary(['influencer_id', 'category_id']);
                $table->foreign('influencer_id')->references('infID')->on('influencers')->onDelete('cascade');
                $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('influencer_categories');
        }
    };
