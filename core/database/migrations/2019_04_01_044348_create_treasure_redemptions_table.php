<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreasureRedemptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treasure_redemptions', function (Blueprint $table) {
            
            $table->increments('id');       // Transaction Id

            $table->string('player_id');
            $table->string('treasure_id');
            $table->string('exchanging_type')->nullable();
            $table->string('equivalent_price')->nullable();
            $table->string('player_phone')->nullable();
            $table->string('agent_phone')->nullable();
            $table->string('collecting_point')->default('Not Collected');
            $table->integer('status')->nullable()->default('-1');
            $table->integer('player_treasure_serial');

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
        Schema::dropIfExists('treasure_redemptions');
    }
}
