<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chatrooms', function (Blueprint $table) {
            $table->uuid('user_id_1');
            $table->uuid('user_id_2');
            $table->uuid('creator_user_id');
            $table->primary(array('user_id_1', 'user_id_2', 'creator_user_id'));
            $table->timestamps();
            $table->foreign('user_id_1')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id_2')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('creator_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chatrooms');
    }
}
