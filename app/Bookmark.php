<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    
    static public function bookmarkedUsers($userId) {
        return Bookmark::where('user_id', $userId)->get();
    }
}
