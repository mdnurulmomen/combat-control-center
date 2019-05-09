<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('username')->nullable()->default('username');
            $table->string('total_kill')->nullable()->default('total_kill');
            $table->string('treasure_won')->nullable()->default('treasure_won');
            $table->string('level')->nullable()->default('level');
            $table->string('location')->nullable()->default('location');
            $table->string('profile_pic')->nullable()->default('profile_pic');

            $table->string('player_id');

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
        Schema::dropIfExists('leaders');
    }
}
