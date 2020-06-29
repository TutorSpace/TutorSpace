<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->bigIncrements('id')->unique();
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('email', 64);
            $table->boolean('is_tutor');
            $table->unsignedBigInteger('first_major_id')->nullable();
            $table->unsignedBigInteger('second_major_id')->nullable();
            $table->string('gpa', 64)->default('N/A');
            $table->unsignedBigInteger('hourly_rate')->nullable();
            $table->unsignedBigInteger('school_year_id')->nullable();
            $table->string('profile_pic_url', 255)->default('placeholder.png');
            $table->string('google_id', 255)->nullable();
            $table->string('password', 255);
            $table->timestamps();

            $table->foreign('first_major_id')->references('id')->on('majors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('second_major_id')->references('id')->on('majors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('school_year_id')->nullable()->references('id')->on('school_years')->onDelete('cascade')->onUpdate('cascade');
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
