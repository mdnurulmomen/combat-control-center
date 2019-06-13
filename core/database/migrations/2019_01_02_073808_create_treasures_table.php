<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTreasuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treasures', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('name')->default('name');
            $table->string('description')->default('description');
            $table->integer('amount')->default(1);
            $table->float('equivalent_price', 12, 2)->nullable()->default(0);
            
            $table->string('collecting_point')->nullable()->default('Nearest');
            $table->string('durability')->nullable()->default('-1');

            $table->mediumInteger('exchanging_coins')->default(0);
            $table->mediumInteger('exchanging_gems')->default(0);
            $table->mediumInteger('exchanging_megabyte')->default(0);

            $table->string('treasure_type_id');
            
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
        Schema::dropIfExists('treasures');
    }
}
