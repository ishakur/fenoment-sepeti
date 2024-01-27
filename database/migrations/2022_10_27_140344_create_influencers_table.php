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
            Schema::create('influencers', function (Blueprint $table) {
                $table->id("infID");
                $table->unsignedBigInteger("userID");
                $table->unsignedBigInteger('agencyID')->nullable(); // ajansa kayitli degilse null, kayitli ise ajans id
                $table->string('platformUserName')->unique()->nullable();
                $table->string('bannerPhoto')->nullable();
                $table->decimal('fenocityPoint', 10, 2)->nullable();
                $table->integer('fenocitySaleCount')->nullable();
                $table->string("bioVerifyCode")->nullable()->nullable();
                $table->boolean("infVerify")->default(false);   // Sosyal medya profiline kod ekleme onayı
                $table->boolean("statsVerify")->default(false); // Paylaşım istatistiklerinin manuel onayı
                $table->boolean("taxPayer")->default(false);  // Vergi Mükellefi mi?
                $table->boolean("isInfDeleted")->default(false);  // Vergi Mükellefi mi?
                $table->foreign('userID')->references('userID')->on('users')->onDelete('cascade')->name('fk_influencers_users');
                $table->foreign('agencyID')->references('agencyID')->on('agencies')->onDelete('cascade')->name('fk_influencers_agencies');
            });
        }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
        public function down()
        {
            Schema::dropIfExists('influencers');
        }
    };
