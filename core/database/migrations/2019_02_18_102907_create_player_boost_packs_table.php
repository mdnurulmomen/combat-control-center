<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerBoostPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_boost_packs', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('melee_boost')->nullable()->default(0);
            $table->bigInteger('light_boost')->nullable()->default(0);
            $table->bigInteger('heavy_boost')->nullable()->default(0);
            $table->bigInteger('ammo_boost')->nullable()->default(0);
            $table->bigInteger('range_boost')->nullable()->default(0);
            $table->bigInteger('speed_boost')->nullable()->default(0);
            $table->bigInteger('armor_boost')->nullable()->default(0);
            $table->bigInteger('xp_multiplier')->nullable()->default(0);
            $table->bigInteger('player_id');

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
        Schema::dropIfExists('player_boost_packs');
    }
}
