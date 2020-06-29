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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tutor_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('course_id');
            $table->timestamp('session_date', 3);
            $table->string('session_start_time', 64);
            $table->string('session_end_time', 64);
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