<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id')->nullable();

            // the reply that this followup is directly responding to
            $table->unsignedBigInteger('reply_id')->nullable();

            // the base reply that this followup is responding to
            $table->unsignedBigInteger('base_reply_id')->nullable();

            $table->unsignedBigInteger('user_id');

            // if is direct reply for the post
            $table->boolean('is_direct_reply');
            $table->text('reply_content');
            $table->unsignedBigInteger('like_count')->default(0);
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('reply_id')->references('id')->on('replies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('base_reply_id')->references('id')->on('replies')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
