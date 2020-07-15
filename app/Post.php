<?php

namespace App;

use App\Reply;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    CONST CACHE_KEY = 'POSTS';

    protected $dates = ['created_at', 'updated_at'];

    public function getRouteKeyName() {
        return 'slug';
    }

    public function getCacheKey($key) {
        $key = Str::upper($key);
        return self::CACHE_KEY . ".$key";
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

    public function getTime() {
        return $this->created_at->format('M d Y');
    }

    // get all the direct replies for the post
    public function replies() {
        return $this->hasMany('App\Reply')->where('is_direct_reply', true);
    }

    public function allReplies() {
        return $this->hasMany('App\Reply');
    }

    // return a boolean indicates whether this post is directly replied (not followup!) by the given user
    public function repliedBy($user) {
        return $this->replies()->where('user_id', $user->id)->exists();
    }

    public function markAsBestReply(Reply $reply) {
        $this->update([
            'best_reply_id' => $reply->id
        ]);

        $reply->update([
            'is_best_reply' => true
        ]);

        if($reply->user->id != $this->user->id) {
            // TODO: notify the reply's poster
        //     $reply->user->notify(new ReplyMarkedAsBestReply($this));

            // TODO: notify all the people who are following this post
        //     foreach($this->usersFollowing as $user) {
        //         $user->notify(new ReplyMarkedAsBestReply($this));
        //     }
        }
    }

    public function bestReply() {
        return $this->belongsTo('App\Reply', 'best_reply_id');
    }

    // get users who are following this post
    public function usersFollowing() {
        return $this->belongsToMany('App\User');
    }

    // return a boolean indicates whether this post is followed by the given user
    public function followedBy($user) {
        return $this->usersFollowing()->where('user_id', $user->id)->exists();
    }

    // get users who upvoted this post
    public function usersUpvoted() {
        return $this->belongsToMany('App\User', 'post_user_upvote');
    }

    // return a boolean indicates whether this post is liked by the given user
    public function upvotedBy($user) {
        return $this->usersUpvoted()->where('user_id', $user->id)->exists();
    }


    public function getYouMayHelpWith() {
        return Cache::remember(
            $this->getCacheKey('you-may-help-with' . "." . Auth::user()->email),
            3600,
            function() {
                Cache::put(
                    $this->getCacheKey('you-may-help-with-update-time' . "." . Auth::user()->email),
                    now(),
                    3600
                );
                return $this->youMayHelpWith();
            }
        );
    }


    // TODO: Modify the method
    private function youMayHelpWith() {
        $user = Auth::user();

        // get all the tags the user is interested in
        $interestedTagIDs = $user->tags()->pluck('id');

        // get recommendations for the posts
        $recommendedPosts = Post::withCount([
                            'replies',
                            'usersUpvoted'
                        ])
                        ->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
                        ->join('tags', 'tags.id', '=', 'post_tag.tag_id')
                        ->whereIn('tags.id', $interestedTagIDs)
                        ->groupBy(['posts.id'])
                        // TODO: modify the order formula
                        ->orderByRaw('0.6 * replies_count + 0.2 * view_count + 0.2 * users_upvoted_count desc')
                        ->take(5)
                        ->get();

        return $recommendedPosts;
    }
}
