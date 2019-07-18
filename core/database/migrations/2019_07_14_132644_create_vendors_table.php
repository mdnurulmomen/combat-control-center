<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            
            $table->increments('id');

            $table->string('name')->nullable()->default('no Name');
            $table->string('logo')->nullable()->default('no Logo');
            $table->string('address')->nullable()->default('no Address');
            $table->string('area_id')->nullable()->default('no Area');
            $table->string('city_id')->nullable()->default('no City');
            $table->string('division_id')->nullable()->default('Dhaka');
            $table->string('mobile')->nullable()->unique();

            $table->tinyInteger('treasure_type_id');
            
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
        Schema::dropIfExists('vendors');
    }
}
