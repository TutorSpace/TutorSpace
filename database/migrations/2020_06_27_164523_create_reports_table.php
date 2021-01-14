<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_tutor_session', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('reporter_id');
            $table->uuid('reportee_id');
            $table->unsignedBigInteger('report_reason_id');
            $table->text('report');
            $table->timestamps();
            $table->foreign('reporter_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('reportee_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('report_reason_id')->references('id')->on('report_reasons')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_tutor_session');
    }
}
