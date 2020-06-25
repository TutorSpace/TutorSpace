<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
    The table that associates subjects with users.
*/
class SubjectToUser extends Model
{
    protected $table = 'subject_user';
}
