<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username')->nullable();
            $table->string('phone')->nullable();
            $table->string('device_info')->nullable();
            $table->string('email')->nullable();
            $table->string('location')->nullable()->default('Dhaka');
            $table->string('facebook_id')->nullable();
            $table->string('facebook_name')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('login_type')->nullable()->default('false');
            $table->string('country')->nullable()->default('Bangladesh');
            $table->string('connection_type')->nullable()->default('false');
            $table->string('type')->nullable()->default('player');
            $table->rememberToken()->nullable();
            $table->string('data_usage')->nullable();
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
        Schema::dropIfExists('users');
    }
}
