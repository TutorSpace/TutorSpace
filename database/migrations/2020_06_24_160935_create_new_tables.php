<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drops all tables.
        Schema::connection('mysql2')->disableForeignKeyConstraints();
        Schema::connection('mysql2')->dropIfExists('tutor_requests');
        Schema::connection('mysql2')->dropIfExists('subject_user');
        Schema::connection('mysql2')->dropIfExists('reviews');
        Schema::connection('mysql2')->dropIfExists('sessions');
        Schema::connection('mysql2')->dropIfExists('reports');
        Schema::connection('mysql2')->dropIfExists('messages');
        Schema::connection('mysql2')->dropIfExists('dashboard_posts');
        Schema::connection('mysql2')->dropIfExists('course_user');
        Schema::connection('mysql2')->dropIfExists('chatrooms');
        Schema::connection('mysql2')->dropIfExists('characteristic_user');
        Schema::connection('mysql2')->dropIfExists('available_times');
        Schema::connection('mysql2')->dropIfExists('bookmark_user');
        Schema::connection('mysql2')->dropIfExists('cancel_reasons');
        Schema::connection('mysql2')->dropIfExists('characteristics');
        Schema::connection('mysql2')->dropIfExists('majors');
        Schema::connection('mysql2')->dropIfExists('report_reasons');
        Schema::connection('mysql2')->dropIfExists('school_years');
        Schema::connection('mysql2')->dropIfExists('subjects');
        Schema::connection('mysql2')->dropIfExists('courses');
        Schema::connection('mysql2')->dropIfExists('users');
        Schema::connection('mysql2')->enableForeignKeyConstraints();

        // Independent tables
        Schema::connection('mysql2')->create('cancel_reasons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('reason');
        });
        Schema::connection('mysql2')->create('characteristics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('characteristic', 64);
            $table->timestamps();
        });
        Schema::connection('mysql2')->create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('course', 64);
            $table->timestamps();
        });
        Schema::connection('mysql2')->create('majors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('major', 45);
        });
        Schema::connection('mysql2')->create('report_reasons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reason', 255);
        });
        Schema::connection('mysql2')->create('school_years', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('school_year', 64);
        });
        Schema::connection('mysql2')->create('subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject', 64);
            $table->timestamps();
        });

        // Dependent tables
        Schema::connection('mysql2')->create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->string('first_name', 45);
            $table->string('last_name', 45);
            $table->string('email', 64);
            $table->unsignedBigInteger('first_major_id');
            $table->foreign('first_major_id')->references('id')->on('majors')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('second_major_id')->nullable();
            $table->foreign('second_major_id')->references('id')->on('majors')->onDelete('cascade')->onUpdate('cascade');
            $table->string('minor', 64)->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->unsignedBigInteger('hourly_rate')->nullable();
            $table->unsignedBigInteger('school_year_id');
            $table->foreign('school_year_id')->nullable()->references('id')->on('school_years')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('is_tutor');
            $table->string('password', 225);
            $table->string('profile_pic_url', 200)->default('placeholder.png');
            $table->timestamps();
            $table->index(array('school_year_id', 'first_major_id', 'second_major_id'));
        });
        Schema::connection('mysql2')->create('bookmark_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('bookmarked_user_id');
            $table->index('bookmarked_user_id');
            $table->primary(array('user_id', 'bookmarked_user_id'));
        });
        Schema::connection('mysql2')->create('available_times', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('available_time_start');
            $table->dateTime('available_time_end');
            $table->index('user_id');
        });
        Schema::connection('mysql2')->create('characteristic_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('characteristic_id');
            $table->foreign('characteristic_id')->references('id')->on('characteristics')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(array('user_id', 'characteristic_id'));
            $table->timestamps();
            $table->index('characteristic_id');
        });
        Schema::connection('mysql2')->create('chatrooms', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id_1');
            $table->foreign('user_id_1')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('user_id_2');
            $table->foreign('user_id_2')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(array('user_id_1', 'user_id_2'));
            $table->index('user_id_2');
        });

        Schema::connection('mysql2')->create('course_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('course_id');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->primary(array('user_id', 'course_id'));
            $table->index('course_id');
        });
        Schema::connection('mysql2')->create('dashboard_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->text('post_message');
            $table->tinyInteger('is_course_post');
            $table->timestamps();
            $table->index('course_id');
        });
        Schema::connection('mysql2')->create('messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('from');
            $table->foreign('from')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('to');
            $table->foreign('to')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->text('message');
            $table->tinyInteger('is_read');
            $table->timestamps();
            $table->index(array('from', 'to'));
        });
        Schema::connection('mysql2')->create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('reporter_id');
            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('reportee_id');
            $table->foreign('reportee_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('report_reason_id');
            $table->foreign('report_reason_id')->references('id')->on('report_reasons')->onDelete('cascade')->onUpdate('cascade');
            $table->text('report');
            $table->timestamps();
            $table->index(array('report_reason_id', 'reporter_id', 'reportee_id'));
        });
        Schema::connection('mysql2')->create('sessions', function (Blueprint $table) {
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
        Schema::connection('mysql2')->create('reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('star_rating');
            $table->unsignedBigInteger('reviewer_id');
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('reviewee_id');
            $table->foreign('reviewee_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('session_id');
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade')->onUpdate('cascade');
            $table->text('review');
            $table->timestamps();
            $table->index(array('reviewer_id', 'reviewee_id', 'session_id'));
        });
        Schema::connection('mysql2')->create('subject_user', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
            $table->primary(array('user_id', 'subject_id'));
            $table->index('subject_id');
        });
        Schema::connection('mysql2')->create('tutor_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tutor_id');
            $table->foreign('tutor_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('course_id')->nullable();
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
            $table->dateTime('tutor_session_date');
            $table->text('message_to_tutor')->nullable();
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade')->onUpdate('cascade');
            $table->tinyInteger('is_course_request');
            $table->string('start_time', 45);
            $table->string('end_time', 45);
            $table->timestamps();
            $table->index(array('tutor_id', 'student_id', 'course_id', 'subject_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drops all tables.
        Schema::connection('mysql2')->disableForeignKeyConstraints();
        Schema::connection('mysql2')->dropIfExists('tutor_requests');
        Schema::connection('mysql2')->dropIfExists('subject_user');
        Schema::connection('mysql2')->dropIfExists('reviews');
        Schema::connection('mysql2')->dropIfExists('sessions');
        Schema::connection('mysql2')->dropIfExists('reports');
        Schema::connection('mysql2')->dropIfExists('messages');
        Schema::connection('mysql2')->dropIfExists('dashboard_posts');
        Schema::connection('mysql2')->dropIfExists('course_user');
        Schema::connection('mysql2')->dropIfExists('chatrooms');
        Schema::connection('mysql2')->dropIfExists('characteristic_user');
        Schema::connection('mysql2')->dropIfExists('available_times');
        Schema::connection('mysql2')->dropIfExists('bookmark_user');
        Schema::connection('mysql2')->dropIfExists('cancel_reasons');
        Schema::connection('mysql2')->dropIfExists('characteristics');
        Schema::connection('mysql2')->dropIfExists('majors');
        Schema::connection('mysql2')->dropIfExists('report_reasons');
        Schema::connection('mysql2')->dropIfExists('school_years');
        Schema::connection('mysql2')->dropIfExists('subjects');
        Schema::connection('mysql2')->dropIfExists('courses');
        Schema::connection('mysql2')->dropIfExists('users');
        Schema::connection('mysql2')->enableForeignKeyConstraints();
    }
}
