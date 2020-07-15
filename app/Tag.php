<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $timestamps = false;

    CONST CACHE_KEY = 'TAGS';

    public function users() {
        return $this->belongsToMany('App\User');
    }

    public function posts() {
        return $this->belongsToMany('App\Post');
    }

    // public function replies() {
    //     return $this->posts()
    //             ->join('replies', 'replies.post_id', '=', 'posts.id')
    //             ->where('replies.is_direct_reply', true)
    //             ->select('replies.*');
    // }

    public function getCacheKey($key) {
        $key = \strtoupper($key);
        return self::CACHE_KEY . ".$key";
    }

    // IMPORTANT: must run scheduler in prod env
    public function updateTrendingTags() {
        Cache::put($this->getCacheKey('trending-tags-update-time'), now(), 3600);
        Cache::put($this->getCacheKey('trending-tags'), $this->trendingTags(), 3600);
    }

    public function getTrendingTags() {
        if(!Cache::has($this->getCacheKey('trending-tags'))) {
            $this->updateTrendingTags();
        }
        return Cache::get($this->getCacheKey('trending-tags'));
    }

    // todo: needed to be modified
    private function trendingTags() {
        $trendingTags = Tag::withCount([
                            'posts'
                        ])
                        ->with([
                            'posts' => function($query) {
                                $query->withCount('replies');
                            }
                        ])
                        // todo: make this post count a larger number in the future
                        ->having('posts_count', '>' , 1)
                        ->orderBy('posts_count', 'desc')
                        ->get();


        foreach($trendingTags as $trendingTag) {
            $trendingTag->replies_count =
                $trendingTag->posts->reduce(
                    function ($count, $post) {
                        return $count + $post->replies_count;
                    }, 0
                );
        }

        return $trendingTags
                ->sortByDesc(
                    function($value, $key) {
                        // TODO: modify the formula
                        return $value["posts_count"] * 2 + $value["replies_count"];
                    })
                ->take(5);
    }




}
