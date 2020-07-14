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



    // needed to be modified
    public static function getTrendingTags() {
        // $trendingTags = Tag
        //                 ::select(
        //                     'tags.*',
        //                     DB::raw('count(replies.id) as replies_count'))
        //                 ->join('post_tag', 'post_tag.tag_id', '=', 'tags.id')
        //                 ->join('posts', 'posts.id', '=', 'post_tag.post_id')
        //                 ->join('replies', 'replies.post_id', '=', 'posts.id')
        //                 ->where('replies.is_direct_reply', true)
        //                 ->groupBy('tags.id')
        //                 ->orderBy('replies_count', 'desc')
        //                 ->get();
        // dd($trendingTags);

        return Tag::withCount([
                'posts'
            ])
            ->with([
                'posts' => function($query) {
                    $query
                    ->withCount([
                        'replies'
                    ]);
                }
            ])
            ->take(5)
            ->get();


        // $results = [];
        // foreach($trendingTags as $trendingTag) {

        // }
    }
}
