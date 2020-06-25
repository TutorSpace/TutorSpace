<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
    The table that associates courses with users.
*/
class CourseToUser extends Model
{
    protected $table = 'course_user';
}
