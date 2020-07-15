<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    public function posts() {
        return $this->belongsToMany('App\Post');
    }

    // public function replies() {
    //     return $this->posts()
    //             ->join('replies', 'replies.post_id', '=', 'posts.id')
    //             ->where('replies.is_direct_reply', true)
    //             ->select('replies.*');
    // }


    // todo: needed to be modified
    public static function getTrendingTags() {

        $trendingTags = Tag::withCount([
                            'posts'
                        ])
                        ->with([
                            'posts' => function($query) {
                                $query->withCount('replies');
                            }
                        ])
                        ->orderBy('posts_count', 'desc')
                        ->get();


        foreach($trendingTags as $trendingTag) {
            $trendingTag->replies_count = $trendingTag->posts->reduce(function ($count, $post) {
                return $count + $post->replies_count;
            }, 0);
        }

        return $trendingTags->sortByDesc(function($value, $key) {
            return $value["posts_count"] + $value["replies_count"];
        })->take(5);
    }
}
