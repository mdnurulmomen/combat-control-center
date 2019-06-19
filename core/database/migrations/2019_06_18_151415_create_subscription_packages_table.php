<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_packages', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->nullable()->default('Name');
            $table->integer('subcription_package_type_id');
            $table->integer('offered_time')->nullable()->default(0);
            $table->integer('offered_game')->nullable()->default(0);
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
        Schema::dropIfExists('subscription_packages');
    }
}
