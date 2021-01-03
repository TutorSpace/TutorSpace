<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTutorLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tutor_levels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tutor_level', 64);
            $table->double('level_experience_lower_bound', 20,2);
            $table->double('level_experience_upper_bound', 20,2);
            $table->double('bonus_rate', 10, 5);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tutor_levels');
    }
}
