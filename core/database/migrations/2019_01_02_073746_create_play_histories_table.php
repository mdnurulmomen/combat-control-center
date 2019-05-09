<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('play_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamp('game_date');
            $table->string('battle_mode')->nullable();
            $table->string('play_duration')->default(0);
            $table->mediumInteger('player_rank');
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
        Schema::dropIfExists('play_histories');
    }
}
