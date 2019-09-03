<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAllTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->bigIncrements('uid');
            $table->string('email')->unique();
            $table->string('name');
            $table->string('avatar');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->ipAddress('ip');
            $table->integer('permission')->default('0');
            $table->dateTime('register_at');
            $table->rememberToken();
        });

        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('invitation_code', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',40);
            $table->integer('max')->default('1');
            $table->string('users',20)->nullable();
            $table->dateTime('expiration')->nullable();
            $table->string('status',20)->nullable();
        });

        Schema::create('options', function (Blueprint $table) {
            $table->string('k')->primary();
            $table->string('v',1500)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('member');
        Schema::drop('password_resets');
        Schema::drop('invitation_code');
        Schema::drop('system');
    }
}
