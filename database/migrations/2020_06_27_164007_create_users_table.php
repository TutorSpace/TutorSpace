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
