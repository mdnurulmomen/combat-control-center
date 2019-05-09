<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayerTreasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('player_treasures', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('redeem_code')->nullable();
            $table->string('collecting_point')->default('Nearest Point');
            $table->timestamp('open_time');
            $table->timestamp('close_time');
            $table->integer('status')->nullable()->default('1');
            $table->integer('treasure_id');
            $table->integer('player_id');
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
        Schema::dropIfExists('player_treasures');
    }
}
