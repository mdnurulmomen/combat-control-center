<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_settings', function (Blueprint $table) {
            $table->increments('id');

            $table->float('game_rate', 8, 2)->nullable()->default(2);
            $table->float('game_version_required', 8, 2);
            $table->float('game_version_optional', 8, 2);

            $table->integer('maintainance_mode')->default(0);
            $table->timestamp('maintainance_start_time')->nullable();
            $table->timestamp('maintainance_end_time')->nullable();
            
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
        Schema::dropIfExists('game_settings');
    }
}
