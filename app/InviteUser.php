<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\Traits\HasCompositePrimaryKey;

class InviteUser extends Model
{
    use HasCompositePrimaryKey;

    protected $table = "invite_user";
    protected $primaryKey = ['user_id', 'invited_user_email'];
    public $incrementing = false;
}
