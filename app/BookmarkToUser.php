<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*
    The table that associates bookmarks with users.
*/
class BookmarkToUser extends Model
{
    protected $table = 'bookmark_user';

    public $timestamps = false;
}
