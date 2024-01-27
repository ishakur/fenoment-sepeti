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
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('influencer_id');
                $table->unsignedBigInteger('product_property_id');
                $table->float('price_for_per_minute', 10, 2);
                $table->decimal('fenocityProductPoint', 10, 2)->nullable();
                $table->integer('fenocityProductSaleCount')->nullable();
                $table->foreign('influencer_id')->references('infID')->on('influencers')->onDelete('cascade');
                $table->foreign('product_property_id')->references('id')->on('product_properties')->onDelete('cascade');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('products');
        }
    };
