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
            $table->uuid('id')->primary();
            $table->uuid('post_id');

            // the reply that this followup is directly responding to
            $table->uuid('reply_id')->nullable();

            // the base reply that this followup is responding to
            $table->uuid('base_reply_id')->nullable();

            $table->uuid('user_id');

            // if is direct reply for the post
            $table->boolean('is_direct_reply');
            $table->boolean('is_best_reply')->default(false);
            $table->text('reply_content');
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
        Schema::dropIfExists('replies');
    }
}
