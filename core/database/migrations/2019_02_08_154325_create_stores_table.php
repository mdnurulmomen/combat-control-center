<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            
            $table->string('id');

            $table->string('type')->default('type');
            $table->string('name')->nullable()->default('character');
            $table->string('description')->nullable()->default('none');
            $table->mediumInteger('amount')->nullable()->default(0);

            $table->float('discount', 5, 2)->default(0);

            $table->float('origin_price_taka', 12, 2)->default(0);
            $table->bigInteger('origin_price_gems')->nullable();
            $table->bigInteger('origin_price_coins')->nullable();
            
            $table->float('offered_price_taka', 12, 2)->default(0);
            $table->bigInteger('offered_price_gems')->nullable();
            $table->bigInteger('offered_price_coins')->nullable();

            $table->string('bundle_id')->nullable();
            
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
        Schema::dropIfExists('stores');
    }
}
