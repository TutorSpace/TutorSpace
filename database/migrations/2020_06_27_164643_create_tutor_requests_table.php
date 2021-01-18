<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_requests', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tutor_id');
            $table->uuid('student_id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('hourly_rate');
            $table->timestamp('session_time_start');
            $table->timestamp('session_time_end');
            $table->boolean('is_in_person');
            $table->string('status')->default('pending'); // status can be pending, accepted, and declined
            $table->text('message_to_tutor')->nullable();
            $table->timestamps();

            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutor_requests');
    }
}
