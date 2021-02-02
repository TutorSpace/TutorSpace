<?php

namespace App;

use App\View;
use App\Reply;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\Forum\MarkedAsBestReplyNotification;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use App\CustomClass\TimeFormatter;

class Post extends Model
{
    use Uuid;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = [];

    CONST CACHE_KEY = 'POSTS';

    // todo: modify the formula
    CONST POPULARITY_FORMULA = '50 * users_upvoted_count + 100 * replies_count + view_count DESC, created_at DESC';

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

    // return time in local (user's local time)
    public function getTimeInTimeZone($timeZone) {
        return $this->created_at->setTimeZone($timeZone)->format('M d Y');
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

        // notify the reply's owner
        $reply->user->notify(new MarkedAsBestReplyNotification($this, $reply->reply_content, false));

        // notify all the people who are following this post
        foreach($this->usersFollowing as $user) {
            if($reply->user->id != $user->id)
                $user->notify(new MarkedAsBestReplyNotification($this, $reply->reply_content, true));
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

    // This is for the views table. To get the total view count on this post, simply retrieve the view_count column
    public function views() {
        return $this->morphMany('App\View', 'viewable');
    }

    // return the posts' daily view count in the past week
    public function viewCntWeek() {
        return $this->views()
                    ->select(['viewed_at', DB::raw('COUNT("viewed_at") as view_count')])
                    ->whereBetween('viewed_at', [
                        // a week is 7 -1 + 1 days including today
                        Carbon::now()->subDays(7 - 1)->format('Y-m-d'),
                        Carbon::now()->format('Y-m-d')
                    ])
                    ->groupBy('viewed_at');
    }

    public static function getViewCntWeek($userId) {
        $beginDate = Carbon::now()->subDays(7 - 1)->format('Y-m-d');
        $endDate = Carbon::now()->format('Y-m-d');

        return View::select([
                        'views.viewed_at',
                        DB::raw('COUNT("views.viewed_at") as view_count')
                    ])
                    ->join('posts', 'posts.id', '=', 'views.viewable_id')
                    ->where('posts.user_id', $userId)
                    ->where('views.viewable_type', 'App\Post')
                    ->whereBetween('views.viewed_at', [
                        // a week is 7 -1 + 1 days including today
                        $beginDate,
                        $endDate
                    ])
                    ->groupBy('views.viewed_at')
                    ->orderBy('views.viewed_at')
                    ->get();
    }



    public function getYouMayHelpWith() {
        if(Auth::check()) {
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
        else {
            return Cache::remember(
                $this->getCacheKey('you-may-help-with'),
                3600,
                function() {
                    Cache::put(
                        $this->getCacheKey('you-may-help-with-update-time'),
                        now(),
                        3600
                    );

                    $posts = $this->queryYouMayHelpWith()
                                ->take(15)
                                ->get();

                    if($posts->count() >= 1) {
                        return $posts->random(min(5, $posts->count()));
                    }
                    else {
                        return $posts;
                    }
                }
            );
        }
    }

    private function youMayHelpWith() {
        $user = Auth::user();

        // get all the tags the user is interested in
        $interestedTagIDs = $user->tags()->pluck('id');

        $posts = $this->queryYouMayHelpWith()
                    ->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
                    ->join('tags', 'tags.id', '=', 'post_tag.tag_id')
                    ->whereIn('tags.id', $interestedTagIDs)
                    ->where('posts.user_id', '!=', $user->id)
                    ->groupBy(['posts.id'])
                    ->take(15)
                    ->get();

        if($posts->count() < 5) {
            $posts = $posts->merge(
                    $this->queryYouMayHelpWith()
                    ->where('posts.user_id', '!=', $user->id)
                    ->take(5 - $posts->count())
                    ->get()
            );
        }

        if($posts->count() >= 1) {
            return $posts->random(min(5, $posts->count()));
        }
        else {
            return $posts;
        }
    }

    public function queryYouMayHelpWith() {
        return Post::withCount([
                    'replies',
                    'usersUpvoted'
                ])
                ->join('post_types', 'post_types.id', 'posts.post_type_id')
                ->where('post_types.post_type', 'Question');
                // ->having('replies_count', '<=', 2)
                //Order the posts by the time they were created and then apply the tags of the user to them
                // ->orderBy('created_at', 'DESC');
    }







}
