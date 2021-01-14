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
            $table->uuid('id')->primary();
            $table->string('first_name', 64);
            $table->string('last_name', 64);
            $table->string('email', 64);
            $table->boolean('is_tutor');
            $table->boolean('is_tutor_verified')->default(false);
            $table->unsignedBigInteger('first_major_id')->nullable();
            $table->unsignedBigInteger('second_major_id')->nullable();
            $table->unsignedBigInteger('minor_id')->nullable();
            $table->decimal('gpa', 3)->nullable();
            $table->unsignedBigInteger('hourly_rate')->nullable();
            $table->unsignedBigInteger('school_year_id')->nullable();
            $table->unsignedBigInteger('tutor_level_id')->default(1);
            $table->string('profile_pic_url', 255)->default('user-profile-photos/placeholder.png');
            $table->string('tutor_verification_status', 255)->default('unsubmitted');
            $table->string('google_id', 255)->nullable();
            $table->string('password', 255)->nullable();
            $table->text('introduction')->nullable();
            $table->boolean('is_invalid')->default(false);
            $table->string('invalid_reason', 256)->nullable();
            $table->string('invalid_redirect_route_name', 64)->nullable();
            $table->bigInteger('experience_points')->default(0);
            $table->timestamps();

            $table->foreign('first_major_id')->references('id')->on('majors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('second_major_id')->references('id')->on('majors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('minor_id')->references('id')->on('minors')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('school_year_id')->nullable()->references('id')->on('school_years')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tutor_level_id')->nullable()->references('id')->on('tutor_levels')->onDelete('cascade')->onUpdate('cascade');
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
