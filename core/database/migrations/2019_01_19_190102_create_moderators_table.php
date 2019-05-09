<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModeratorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moderators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstname')->nullable()->default('Full');
            $table->string('lastname')->nullable()->default('Name');
            $table->string('username')->default('Moderator');
            $table->string('password');
            $table->rememberToken();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('picture')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
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
        Schema::dropIfExists('moderators');
    }
}
