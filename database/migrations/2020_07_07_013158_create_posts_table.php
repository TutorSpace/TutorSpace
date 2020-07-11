<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->text('content');
            $table->unsignedBigInteger('view_count')->default(0);

            // // I put these two columns for faster rendering time in preview. Remember to always update the upvote count and reply count of the POST if any upvote/reply updates
            // $table->unsignedBigInteger('upvote_count')->default(0);
            // $table->unsignedBigInteger('reply_count')->default(0);

            $table->string('thumbNail')->nullable();

            $table->string('slug')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('best_reply_id')->nullable();
            $table->unsignedBigInteger('post_type_id');
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
        Schema::dropIfExists('posts');
    }
}
