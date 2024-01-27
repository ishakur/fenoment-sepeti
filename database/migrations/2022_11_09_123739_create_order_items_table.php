<?php

use App\Enum\OrderStatus;
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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('product_id');
            $table->enum('status', OrderStatus::cases())->default(OrderStatus::OnChart);
            $table->boolean('seller_confirmation')->default(false);
            $table->unsignedInteger('ad_duration');
            $table->float('ad_total_price', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('order_details')->onDelete('cascade');
            $table->foreign('seller_id')->references('infID')->on('influencers')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};
