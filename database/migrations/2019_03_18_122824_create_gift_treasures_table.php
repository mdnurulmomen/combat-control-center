<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftTreasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_treasures', function (Blueprint $table) {
            $table->mediumIncrements('id');

            $table->mediumInteger('treasure_id')->nullable()->default(-1);
            $table->mediumInteger('treasure_cost')->nullable()->default(0);
            $table->integer('required_percentage')->nullable()->default(0);
            $table->mediumInteger('required_earn')->nullable()->default(0);

            $table->mediumInteger('total_treasure_gifted')->nullable()->default(0);
            $table->mediumInteger('total_treasure_collected')->nullable()->default(0);


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
        Schema::dropIfExists('gift_treasures');
    }
}
