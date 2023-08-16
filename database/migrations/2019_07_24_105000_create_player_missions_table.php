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

            $table->mediumInteger('progress_play_number')->nullable();
            $table->float('progress_play_time', 8, 2)->nullable();
            // $table->mediumInteger('progress_play_time')->nullable();
            $table->mediumInteger('progress_kill_opponent')->nullable();
            $table->mediumInteger('progress_kill_monster')->nullable();
            $table->mediumInteger('progress_win_top_time')->nullable();
            $table->mediumInteger('progress_among_two_time')->nullable();
            $table->mediumInteger('progress_among_three_time')->nullable();
            $table->mediumInteger('progress_among_five_time')->nullable();

            $table->boolean('rewarded')->nullable()->default(false);
            $table->boolean('mission_completion')->nullable()->default(false);

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
