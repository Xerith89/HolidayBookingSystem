<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHolidayRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holiday_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('request_staff_id');
            $table->datetime('request_start');
            $table->datetime('request_end');
            $table->string('requester_email_address');
            $table->text('requester_comments')->nullable;
            $table->string('request_status');
            $table->string('reviewer_name')->nullable;
            $table->text('reviewer_comments')->nullable;
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
        Schema::dropIfExists('holiday_requests');
    }
}
