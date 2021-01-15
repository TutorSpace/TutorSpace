<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('star_rating');
            $table->uuid('reviewer_id');
            $table->uuid('reviewee_id');
            $table->uuid('session_id')->unique();
            $table->text('review');
            $table->timestamps();
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('reviewee_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
