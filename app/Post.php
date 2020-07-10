<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

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

    public function getTime() {
        return $this->created_at->format('M d Y');
    }

    // get the reply for the discussion
    public function replies() {
        return $this->hasMany('App\Reply');
    }

    public function markAsBestReply(Reply $reply) {
        // $this->update([
        //     'reply_id' => $reply->id
        // ]);

        // if($reply->user->id != $this->user->id) {
        //     // notify the reply's poster
        //     $reply->user->notify(new ReplyMarkedAsBestReply($this));

        //     // notify all the people who are following this discussion
        //     foreach($this->usersFollowing as $user) {
        //         $user->notify(new ReplyMarkedAsBestReply($this));
        //     }
        // }
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
        return $this->usersFollowing()->where('user_id', $user->id);
    }

    // get users who upvoted this post
    public function usersUpvoted() {
        return $this->belongsToMany('App\User', 'post_user_upvote');
    }

    // return a boolean indicates whether this post is liked by the given user
    public function upvotedBy($user) {
        return $this->usersUpvoted()->where('user_id', $user->id)->exists();
    }

    // returh the number of likes of this post
    public function getUpvotesCount() {
        return $this->usersUpvoted()->count();
    }


}
