<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGiftBoostPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_boost_packs', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('gift_melee_boost')->nullable()->default(0);
            $table->integer('gift_light_boost')->nullable()->default(0);
            $table->integer('gift_heavy_boost')->nullable()->default(0);
            $table->integer('gift_ammo_boost')->nullable()->default(0);
            $table->integer('gift_range_boost')->nullable()->default(0);
            $table->integer('gift_speed_boost')->nullable()->default(0);
            $table->integer('gift_armor_boost')->nullable()->default(0);
            $table->integer('gift_multiplier_boost')->nullable()->default(0);

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
        Schema::dropIfExists('gift_boost_packs');
    }
}
