<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // important
    public function getRouteKeyName() {
        return 'slug';
    }

}
