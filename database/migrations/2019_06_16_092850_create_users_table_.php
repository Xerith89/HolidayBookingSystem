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
            $table->string('password');
            $table->string('email')->unique;
            $table->string('name');
            $table->boolean('admin_user');
            $table->decimal('currentyear_holiday_entitlement',2);
            $table->decimal('currentyear_holiday_used',2);
            $table->decimal('nextyear_holiday_entitlement',2);
            $table->decimal('nextyear_holiday_used',2);
            $table->decimal('pending_holiday_used',2);
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
