<?php

namespace App;

use App\Reply;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    // get all the followups with this reply as their base reply (contain the followups of the followups...)
    public function replies() {
        return $this->hasMany('App\Reply', 'base_reply_id');
    }

    // return itself if it is a direct reply, return the base reply if it is a followup
    public function baseReply() {
        if($this->isDirectReply())
            return $this;
        else {
            // return $this->belongsTo('App\Reply', 'base_reply_id');
            return Reply::find($this->base_reply_id);
        }
    }

    // get all the direct followups of this reply
    public function followups() {
        return $this->hasMany('App\Reply');
    }

    public function followupedBy($user) {
        return $this->followups()->where('user_id', $user->id)->exists();
    }

    // get the reply that this followup is responding to
    public function reply() {
        return $this->belongsTo('App\Reply');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    // return which post this reply/followup is responding to
    public function post() {
        return $this->belongsTo('App\Post');
    }

    public function isDirectReply() {
        return $this->is_direct_reply;
    }

    // get users who upvoted this post
    public function usersUpvoted() {
        return $this->belongsToMany('App\User', 'reply_user_upvote');
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
