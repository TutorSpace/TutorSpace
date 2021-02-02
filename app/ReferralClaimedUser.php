<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralClaimedUser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email', 'bonus_amount_dollar', 'is_invited_by_user_id', 'is_inviting_user_email'];
}
