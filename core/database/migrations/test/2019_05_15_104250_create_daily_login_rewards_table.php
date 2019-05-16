<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyLoginRewardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_login_rewards', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->default(0);
            $table->mediumInteger('amount')->nullable()->default(0);
            $table->mediumText('description')->nullable();
            $table->string('reward_type_id');

            $table->softDeletes();
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
        Schema::dropIfExists('daily_login_rewards');
    }
}
