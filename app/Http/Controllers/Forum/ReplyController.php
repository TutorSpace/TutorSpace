<?php

namespace App\Http\Controllers\Forum;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ReplyController extends Controller
{
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


        return response()->json([
            'successMsg' => 'Successfully added the reply!',
            'num' => $post->reply_count
        ]);
    }
}
