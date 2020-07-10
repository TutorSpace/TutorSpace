<?php

namespace App\Http\Controllers\Forum;

use App\Post;
use App\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReplyController extends Controller
{
    public function __construct() {
        $this->middleware(['auth']);
    }

    // for replies that are directly responding to the post
    public function storeReply(Request $request, Post $post) {
        Auth::user()->replies()->create([
            'reply_content' => $request->input('content'),
            'is_direct_reply' => true,
            'post_id' => $post->id
        ]);

        $post->update([
            'reply_count' => $post->reply_count + 1
        ]);

        // todo: send notification to the related users
        // if($post->user->id != auth()->user()->id) {
        //     // notify the reply's poster
        //     $post->user->notify(new NewReplyAdded($post));

        //     // notify all people who are following this post
        //     foreach($post->usersFollowing as $user) {
        //         $user->notify(new NewReplyAdded($post));
        //     }
        // }

        return redirect()->back()->with([
            'successMsg' => 'Successfully added the reply!'
        ]);

        // return response()->json([
        //     'successMsg' => 'Successfully added the reply!',
        //     'num' => $post->reply_count
        // ]);
    }

    public function storeFollowup(Request $request, Reply $reply) {
        // the user can not reply to his own replies
        Gate::authorize('followup', $reply);

        $baseReply = $reply->baseReply();

        // no post_id for followups
        Auth::user()->replies()->create([
            'reply_content' => $request->input('content'),
            'is_direct_reply' => false,
            'reply_id' => $reply->id,
            'base_reply_id' => $baseReply->id
        ]);

        // todo: send notifications to the related users
        // $reply->user->notify(new NewFollowupAdded(Discussion::find($baseReply->discussion_id)));

        return redirect()->back()->with('successMsg', 'Successfully added the reply!');
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
            'num' => $reply->getUpvotesCount()
        ]);
    }

}
