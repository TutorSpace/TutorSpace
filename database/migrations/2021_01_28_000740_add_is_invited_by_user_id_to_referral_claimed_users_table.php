<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsInvitedByUserIdToReferralClaimedUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referral_claimed_users', function (Blueprint $table) {
            $table->uuid('is_invited_by_user_id')->nullable();
            $table->string('is_inviting_user_email')->nullable();

            $table->foreign('is_invited_by_user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referral_claimed_users', function (Blueprint $table) {
            //
        });
    }
}
