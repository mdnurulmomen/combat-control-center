<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGemPacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gem_packs', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('custom_id');
            
            $table->string('name')->nullable()->default('Gems Pack');
            $table->string('type')->nullable()->default('Gems Pack');
            $table->string('description')->nullable()->default('none');

            $table->mediumInteger('amount')->nullable()->default(0);

            $table->float('discount_taka', 5, 2)->nullable()->default(0);
            $table->integer('discount_coins')->nullable()->default(0);
            
            $table->float('price_taka', 12, 2)->default(0);
            $table->bigInteger('price_coins')->default(0);

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
        Schema::dropIfExists('gem_packs');
    }
}
