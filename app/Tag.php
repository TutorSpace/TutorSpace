<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    public function posts() {
        return $this->belongsToMany('App\Post');
    }


    // todo: modify this function
    public static function getTrendingTags() {
        return Tag::withCount([
                'posts'
            ])
            ->with([
                'posts' => function($query) {
                    $query->withCount([
                        'replies'
                    ]);
                }
            ])
            ->take(5)
            ->get();
    }
}
