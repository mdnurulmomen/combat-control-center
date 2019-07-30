<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->increments('id');

            $table->bigInteger('current_gems_earning')->nullable()->default(0);
            $table->bigInteger('total_gems_earning')->nullable()->default(0);

            $table->float('current_currency_earning', 10, 2)->nullable()->default(0);
            $table->float('total_currency_earning', 20, 2)->nullable()->default(0);

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
        Schema::dropIfExists('earnings');
    }
}
