<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyLoginChecksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_login_checks', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('player_id');
            $table->bigInteger('consecutive_days')->default(1);
            $table->integer('reward_status')->default(1);
            
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
        Schema::dropIfExists('daily_login_checks');
    }
}
