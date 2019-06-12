<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('missions', function (Blueprint $table) {

            $table->increments('id');

            $table->string('name')->nullable()->default('name');
            $table->longText('description')->nullable();
            $table->mediumInteger('play_number')->nullable()->default(0);
            $table->mediumInteger('play_time')->nullable()->default(0);
            $table->mediumInteger('damage_opponent')->nullable()->default(0);
            $table->mediumInteger('kill_opponent')->nullable()->default(0);
            $table->mediumInteger('kill_monster')->nullable()->default(0);
            $table->mediumInteger('travel_distance')->nullable()->default(0);
            $table->mediumInteger('win_top_time')->nullable()->default(0);
            $table->mediumInteger('among_two_time')->nullable()->default(0);
            $table->mediumInteger('among_three_time')->nullable()->default(0);
            $table->mediumInteger('among_five_time')->nullable()->default(0);
            $table->mediumInteger('mission_type_id');
            
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
        Schema::dropIfExists('missions');
    }
}
