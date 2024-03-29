<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tutor_id');
            $table->uuid('student_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('hourly_rate');
            $table->timestamp('session_time_start');
            $table->timestamp('session_time_end');
            $table->boolean('is_in_person');
            $table->boolean('is_upcoming')->default(true);
            $table->boolean('is_canceled')->default(false);
            $table->unsignedBigInteger('cancel_reason_id')->nullable();
            $table->boolean('is_notified')->default(false);
            $table->timestamps();

            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cancel_reason_id')->references('id')->on('session_cancel_reasons')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sessions');
    }
}
