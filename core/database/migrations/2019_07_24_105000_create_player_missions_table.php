<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_missions', function (Blueprint $table) {
            
            $table->increments('id');

            $table->mediumInteger('progress_play_number')->nullable()->default(0);
            $table->mediumInteger('progress_play_time')->nullable()->default(0);
            $table->mediumInteger('progress_kill_opponent')->nullable()->default(0);
            $table->mediumInteger('progress_kill_monster')->nullable()->default(0);
            $table->mediumInteger('progress_win_top_time')->nullable()->default(0);
            $table->mediumInteger('progress_among_two_time')->nullable()->default(0);
            $table->mediumInteger('progress_among_three_time')->nullable()->default(0);
            $table->mediumInteger('progress_among_five_time')->nullable()->default(0);

            $table->mediumInteger('player_id');
            $table->mediumInteger('mission_id');

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
        Schema::dropIfExists('player_missions');
    }
}
