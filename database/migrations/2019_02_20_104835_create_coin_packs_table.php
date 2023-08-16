<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoinPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_packs', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('custom_id');

            $table->string('name')->nullable()->default('Coins Pack');
            $table->string('type')->nullable()->default('Coins Pack');
            $table->string('description')->nullable()->default('none');
            
            $table->mediumInteger('amount')->nullable()->default(0);

            $table->float('discount_taka', 5, 2)->nullable()->default(0);
            $table->integer('discount_gems')->nullable()->default(0);

            $table->float('price_taka', 12, 2)->default(0);
            $table->bigInteger('price_gems')->default(0);

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
        Schema::dropIfExists('coin_packs');
    }
}
