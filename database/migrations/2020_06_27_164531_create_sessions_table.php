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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tutor_id')->index();
            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('student_id')->index();
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('is_course');
            $table->unsignedBigInteger('course_id')->nullable()->index();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('subject_id')->nullable()->index();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('date');
            $table->string('start_time', 45);
            $table->string('location', 45)->nullable();
            $table->tinyInteger('is_upcoming');
            $table->tinyInteger('is_canceled');
            $table->unsignedBigInteger('cancel_reason_id')->nullable()->index();
            $table->foreign('cancel_reason_id')->references('id')->on('cancel_reasons')->onDelete('cascade')->onUpdate('cascade');
            $table->string('cancel_notes', 45)->nullable();
            $table->string('end_time', 45);
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
        Schema::dropIfExists('sessions');
    }
}
