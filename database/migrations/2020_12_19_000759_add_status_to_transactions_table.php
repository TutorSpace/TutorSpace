<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusToTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('payment_intent_id')->nullable()->change();
            $table->dropColumn('is_successful');
            $table->enum('invoice_status', ['draft', 'open', 'paid', 'uncollectible', 'void']);
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
            $table->string('payment_intent_id')->nullable(false)->change();
            $table->boolean('is_successful')->default(0);
            $table->dropColumn('invoice_status');
        });
    }
}
