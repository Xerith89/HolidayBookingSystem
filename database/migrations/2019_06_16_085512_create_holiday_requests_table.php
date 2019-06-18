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
            $table->date('request_start');
            $table->time('request_start_time');
            $table->date('request_end');
            $table->time('request_end_time');
            $table->decimal('total_days_requested', 2, 2);
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
