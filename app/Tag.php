<?php

namespace App;

use Carbon\Carbon;
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

        //Stores the current day
        $current = Carbon::now();
        foreach($trendingTags as $trendingTag) {
            //Stores the number of days since the latest post for a particular tag was created
            $trendingTag->created_at_score =
                $trendingTag->posts()
                ->select('created_at')
                ->orderBy('created_at', 'DESC')
                ->first()
                ->created_at
                ->diffInDays($current) + 1;
            //Stores the number of replies for each tag
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
                        /* Since the created_at value is inversely proportional to the ranking i.e the lesser the value of
                        created_at the more weightage should be applied to the corresponding tag's trend */
                        return $value["posts_count"] * 2 + $value["replies_count"] * 1.3 / $value['created_at_score'];
                    })
                ->take(5);
    }




}
