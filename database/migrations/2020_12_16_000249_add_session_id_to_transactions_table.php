<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSessionIdToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('refund_id')->nullable();
            $table->string('invoice_id');
            $table->uuid('session_id');
            $table->timestamp('refund_requested_time')->nullable();

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
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign('transactions_session_id_foreign');
            $table->dropColumn('session_id');
            $table->dropColumn('invoice_id');
            $table->dropColumn('refund_id');
            $table->dropColumn('refund_requested_time');
        });
    }
}
