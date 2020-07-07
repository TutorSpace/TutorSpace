<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function getRouteKeyName() {
        return 'slug';
    }

    public function post_type() {
        return $this->belongsTo('App\PostType');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function tags() {
        return $this->belongsToMany('App\Tag');
    }

}
