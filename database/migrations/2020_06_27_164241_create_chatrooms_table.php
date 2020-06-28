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
            $table->unsignedBigInteger('user_id_1');
            $table->foreign('user_id_1')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('user_id_2');
            $table->foreign('user_id_2')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->primary(array('user_id_1', 'user_id_2'));
            $table->index('user_id_2');
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
