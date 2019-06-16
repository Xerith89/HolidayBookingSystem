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
            $table->string('staff_id')->unique;
            $table->string('username')->unique;
            $table->string('password');
            $table->string('email_address')->unique;
            $table->string('name');
            $table->boolean('admin_user');
            $table->integer('base_holiday_entitlement');
            $table->integer('additional_holiday_entitlement');
            $table->integer('amount_holiday_used');
            $table->char('remember_token',100)->nullable;
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
