<?php

namespace App\Http\Controllers\Forum;

use App\Post;
use App\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\Forum\NewReplyAddedNotification;
use App\Notifications\Forum\NewFollowupAddedNotification;

class ReplyController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    // for replies that are directly responding to the post
    public function storeReply(Request $request, Post $post) {
        $newReplyId = Auth::user()->replies()->create([
            'reply_content' => $request->input('content'),
            'is_direct_reply' => true,
            'post_id' => $post->id
        ])->id;

        // notify the post's owner
        if($post->user->id != Auth::id()) {
            $post->user->notify(new NewReplyAddedNotification($post));
        }

        // notify all people who are following this post
        foreach($post->usersFollowing as $user) {
            $user->notify(new NewReplyAddedNotification($post));
        }

        return redirect()->back()->with([
            'successMsg' => 'Successfully added the reply!',
            'newReplyId' => $newReplyId
        ]);
    }

    public function storeFollowup(Request $request, Reply $reply) {

        $baseReply = $reply->baseReply();

        $newFollowupId = Auth::user()->replies()->create([
            'post_id' => $baseReply->post_id,
            'reply_content' => $request->input('content'),
            'is_direct_reply' => false,
            'reply_id' => $reply->id,
            'base_reply_id' => $baseReply->id
        ])->id;

        // send notifications to the reply's user
        if($reply->user->id != Auth::id()) {
            $reply->user->notify(new NewFollowupAddedNotification($baseReply->post));
        }


        return redirect()->back()->with([
            'successMsg' => 'Successfully added the reply!',
            'newFollowupId' => $newFollowupId
        ]);
    }



    public function upvote(Request $request, Reply $reply) {
        $user = Auth::user();
        if($reply->upvotedBy($user)) {
            $reply->usersUpvoted()->detach($user);
        }
        else {
            $reply->usersUpvoted()->attach($user);
        }

        return response()->json([
            'num' => $reply->usersUpvoted()->count()
        ]);
    }

}
