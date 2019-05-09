<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('coins')->nullable()->default(0);
            $table->bigInteger('gems')->nullable()->default(0);
            $table->bigInteger('xp_point')->nullable()->default(0);
            $table->bigInteger('battle_played')->nullable()->default(0);
            $table->bigInteger('battle_wins')->nullable()->default(0);
            $table->bigInteger('treasure_won')->nullable()->default(0);
            $table->bigInteger('treasure_collected')->nullable()->default(0);
            $table->bigInteger('opponent_killed')->nullable()->default(0);
            $table->bigInteger('monster_killed')->nullable()->default(0);
            $table->bigInteger('double_killed')->nullable()->default(0);
            $table->bigInteger('triple_killed')->nullable()->default(0);
            $table->bigInteger('items_collected')->nullable()->default(0);
            $table->bigInteger('guns_collected')->nullable()->default(0);
            $table->bigInteger('crates_collected')->nullable()->default(0);
            $table->bigInteger('air_drops')->nullable()->default(0);
            $table->bigInteger('player_level')->nullable()->default(1);
            
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
        Schema::dropIfExists('player_statistics');
    }
}
