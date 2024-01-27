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
        Schema ::create( 'order_details' , function( Blueprint $table ) {
            $table -> id();
            $table->unsignedBigInteger('purchaser_id');
            $table->enum('status', OrderStatus::cases())->default(OrderStatus::OnChart);
            $table->float('total_price', 10, 2)->default(0);
            $table->unsignedBigInteger('payment_id')->nullable();
            $table -> timestamps();

            $table -> foreign( 'purchaser_id' ) -> references( 'userID' ) -> on( 'users' ) -> onDelete( 'cascade' );
            //            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema ::dropIfExists( 'order_details' );
    }
};
