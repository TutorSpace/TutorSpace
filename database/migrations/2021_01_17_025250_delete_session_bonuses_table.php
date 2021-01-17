<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteSessionBonusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('session_bonuses');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('session_bonuses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('amount');
            $table->string('transfer_id');  // Stripe Transfer object id
            $table->string('transfer_reversal_id')->nullable();  // Stripe TransferReversal object id
            $table->uuid('user_id');
            $table->uuid('session_id');
            $table->boolean('is_refunded')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('session_id')->references('id')->on('sessions')->onDelete('cascade')->onUpdate('cascade');
        });
    }
}
