<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $dates = ['created_at', 'updated_at'];

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

    public function getThumbNail() {
        preg_match('/\<img.+src\=(?:\"|\')(.+?)(?:\"|\')(?:.+?)\>/', $this->content, $result);
        return $result;
    }

    public function getTimeAgo() {
        return $this->created_at->diffForHumans();
    }


}
