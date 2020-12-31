<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSessionBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('session_bonuses', function (Blueprint $table) {
            $table->bigIncrements('id')->unique();
            $table->bigInteger('amount');
            $table->string('transfer_id');  // Stripe Transfer object id
            $table->string('transfer_reversal_id')->nullable();  // Stripe TransferReversal object id
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('session_id');
            $table->boolean('is_refunded')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('session_bonuses');
    }
}
