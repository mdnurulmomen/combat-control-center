<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnimationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('animations', function (Blueprint $table) {
            
            $table->bigIncrements('id');
            $table->string('custom_id');
            
            $table->string('name')->nullable()->default('animation');
            $table->string('type')->nullable()->default('animation');
            $table->string('description')->nullable()->default('none');

            $table->float('discount_taka', 5, 2)->nullable()->default(0);
            $table->float('discount_gems', 5, 2)->nullable()->default(0);
            $table->float('discount_coins', 5, 2)->nullable()->default(0);

            $table->float('price_taka', 12, 2)->default(0);
            $table->bigInteger('price_gems')->default(0);
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
        Schema::dropIfExists('animations');
    }
}
