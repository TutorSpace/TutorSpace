<?php

namespace App\Http\Controllers\Forum;

use App\Events\MarkedAsBestReply;
use App\Events\NotePosted;
use App\Events\PostLikeReceived;
use App\Post;
use App\Reply;
use App\PostType;
use App\PostDraft;
use Carbon\Carbon;
use Facades\App\Tag;
use App\Events\PostViewed;
use App\Rules\WordCountGTE;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;


use Illuminate\Support\Facades\Log;


class PostController extends Controller
{
    private static $POSTS_PER_PAGE = 5;

    public function __construct() {
        $this->middleware(['auth'])->except([
            'index',
            'show',
            'search',
            'indexPopular',
            'indexLatest'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['tags', 'user'])->withCount(['usersUpvoted', 'replies', 'tags']);

        if(Auth::check()) {
            $user = Auth::user();
            $interestedTagIDs = $user->tags()->pluck('id');
            $posts = $posts->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
                            ->join('tags', 'tags.id', '=', 'post_tag.tag_id')
                            ->whereIn('tags.id', $interestedTagIDs)
                            ->groupBy(['posts.id'])
                            ->orderByRaw(POST::POPULARITY_FORMULA)
                            ->get();

            // to put the recommmended posts before the general popular posts
            $posts = $posts->merge(
                Post::with(['tags', 'user'])
                    ->withCount(['usersUpvoted', 'replies', 'tags'])
                    ->orderByRaw(POST::POPULARITY_FORMULA)
                    ->get()
            );
        }
        else {
            $posts = $posts->orderByRaw(POST::POPULARITY_FORMULA);
        }

        $posts = $posts->paginate(self::$POSTS_PER_PAGE);

        return view('forum.index', [
            'posts' => $posts,
            'pageTitle' => 'Forum',
            'trendingTags' => Tag::getTrendingTags(),
            'youMayHelpWithPosts' => \Facades\App\Post::getYouMayHelpWith()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $oldPostData = session()->get('oldPostData');

        return view('forum.create', [
            'postDraft' => PostDraft::firstOrNew([
                'user_id' => Auth::user()->id,
            ],[
                'post_type_id' => 0
            ]),
            'trendingTags' => Tag::getTrendingTags(),
            'youMayHelpWithPosts' => \Facades\App\Post::getYouMayHelpWith(),
            'oldPostData' => $oldPostData,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // store old form data in session
        $oldPostData = [
            'post-type'=>$request['post-type'],
            'post-title'=>$request["post-title"],
            'post-content'=>$request["post-content"],
            'tags'=>$request["tags"],
        ];
        $request->session()->flash('oldPostData', $oldPostData);

        // validate
        $request->validate([
            'post-type' => [
                'required',
                'exists:post_types,id'
            ],
            'post-title' => [
                'required',
                'unique:posts,title',
                new WordCountGTE(3)
            ],
            'post-content' => [
                'required',
                new WordCountGTE(5)
            ],
            'tags' => [
                'required',
                'array',
                'min:1',
                'max:7'
            ],
            'tags.*' => [
                'exists:tags,id'
            ]
        ]);

        DB::transaction(function () use($request) {
            $post = new Post();
            $post->title = $request->input('post-title');
            $post->content = $request->input('post-content');
            $post->slug = Str::slug($request->input('post-title'));
            if(!empty($post->getThumbNail())) {
                $post->thumbNail = $post->getThumbNail()[1];
            }

            $post->post_type()->associate(PostType::find($request->input('post-type')));
            $post->user()->associate(Auth::user());

            $post->save();

            $post->tags()->attach($request->input('tags'));

            // important: post_type id=2 must be class note, and if this changes, 'handlenoteposted' must also be changed!
            // Trigger event to add experience
            if ($post->post_type->id == 2) {  // 2 means Class Note
                event(new NotePosted($post));
            }
        });


        $postDraft = PostDraft::where('user_id', Auth::user()->id)->first();
        if($postDraft) {
            $postDraft->delete();
        }

        return redirect()->route('posts.index')->with([
            'successMsg' => 'You successfully created a new post!'
        ]);
    }

    public function storeAsDraft(Request $request) {
        // store old form data in session
        $oldPostData = [
            'post-type'=>$request['post-type'],
            'post-title'=>$request["post-title"],
            'post-content'=>$request["post-content"],
            'tags'=>$request["tags"],
        ];
        $request->session()->flash('oldPostData', $oldPostData);

        // validate
        $request->validate([
            'post-type' => [
                'required',
                'exists:post_types,id'
            ],
            'post-title' => [
                'required',
                'unique:posts,title',
                new WordCountGTE(3)
            ],
            'post-content' => [
                'required',
                new WordCountGTE(5)
            ],
            'tags' => [
                'required',
                'array',
                'min:1'
            ],
            'tags.*' => [
                'exists:tags,id'
            ]
        ]);

        $postDraft = PostDraft::updateOrCreate([
            'user_id' => Auth::user()->id,
        ],[
            'title' => $request->input('post-title'),
            'content' => $request->input('post-content'),
            'post_type_id' => $request->input('post-type'),
            'tags' => implode(',', $request->input('tags'))
        ]);

        return redirect()->route('posts.create')->with([
            'successMsg' => 'Your post draft is saved successfully!'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Post $post)
    {
        $cookieName = "viewed-$post->slug";


        if (!$request->cookie($cookieName)) {
            event(new PostViewed($post));
            Cookie::queue(Cookie::make($cookieName, 'true', 60));
        }

        return view('forum.show', [
            'trendingTags' => Tag::getTrendingTags(),
            'post' => $post
                        ->loadCount([
                            'usersUpvoted',
                            'replies'
                        ])
                        ->load([
                            'replies' => function($query) {
                                $query->withCount(['usersUpvoted', 'replies'])->orderBy('is_best_reply', 'desc');
                            },
                            'replies.replies' => function($query) {
                                $query->withCount('usersUpvoted');
                            },
                            'replies.usersUpvoted' => function($query) {
                                if(Auth::check())
                                    $query->where('user_id', Auth::user()->id);
                            },
                            'replies.user.firstMajor',

                            'replies.replies.reply.user',
                            'replies.replies.user',
                            'replies.replies.usersUpvoted' => function($query) {
                                if(Auth::check())
                                    $query->where('user_id', Auth::user()->id);
                            },
                        ]),
            'youMayHelpWithPosts' => \Facades\App\Post::getYouMayHelpWith()

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json([
            'successMsg' => 'Successfully deleted the post!'
        ]);
    }

    public function markAsBestReply(Post $post, Reply $reply) {
        $this->authorize('markAsBestReply', [$post, $reply]);

        $post->markAsBestReply($reply);

        // Trigger event to add experience
        if ($post->view_count >= 100) {
            event(new MarkedAsBestReply($reply));
        }

        return redirect()->back()->with([
            'successMsg' => 'Marked as best reply.'
        ]);
    }

    public function showMyFollows() {
        return view('forum.my_follows', [
            'trendingTags' => Tag::getTrendingTags(),
            'posts' => Auth::user()->followedPosts()->with(['tags', 'user'])->withCount(['usersUpvoted', 'replies', 'tags'])->orderBy('posts.created_at', 'DESC')->paginate(self::$POSTS_PER_PAGE),
            'youMayHelpWithPosts' => \Facades\App\Post::getYouMayHelpWith()
        ]);
    }

    public function showMyParticipated() {
        return view('forum.index', [
            'trendingTags' => Tag::getTrendingTags(),
            'youMayHelpWithPosts' => \Facades\App\Post::getYouMayHelpWith(),
            'posts' => Auth::user()->participatedPosts()->with(['tags', 'user'])->withCount(['usersUpvoted', 'replies', 'tags'])->orderBy('posts.created_at', 'DESC')->paginate(self::$POSTS_PER_PAGE),
            'pageTitle' => 'Forum - Participated Posts'
        ]);
    }

    public function showMyPosts() {
        return view('forum.my_posts', [
            'trendingTags' => Tag::getTrendingTags(),
            'youMayHelpWithPosts' => \Facades\App\Post::getYouMayHelpWith(),
            'posts' => Auth::user()->posts()->with(['tags', 'user'])->withCount(['usersUpvoted', 'replies', 'tags'])->orderBy('posts.created_at', 'DESC')->paginate(self::$POSTS_PER_PAGE)
        ]);
    }

    public function uploadPostImg(Request $request) {
        reset($_FILES);
        $temp = current($_FILES);

        if(is_uploaded_file($temp['tmp_name'])){
            // Sanitize input
            if(preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])){
                return response()->json([
                    'errorMsg' => 'Invalid File Name!'
                ]);
            }

            // Verify extension
            if(!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("jpg", "png", "jpeg"))){
                return response()->json([
                    'errorMsg' => 'Invalid File Extension!'
                ]);
            }

            // upload the file
            $uploadedFileName = $request->file('file')->store('/user-profile-photos');

            return response()->json([
                'location' => Storage::url($uploadedFileName)
            ]);
        } else {
            // Notify editor that the upload failed
            return response()->json([
                'errorMsg' => 'Something went wrong when uploading the image. Please check your image extension and file size.'
            ]);
        }
    }

    public function upvote(Request $request, Post $post) {
        $user = Auth::user();
        if($user->hasUpvotedPost($post)) {
            $user->upvotedPosts()->detach($post);
            // Trigger event to add experience
            event(new PostLikeReceived($post, false));
        }
        else {
            $user->upvotedPosts()->attach($post);
            // Trigger event to add experience
            event(new PostLikeReceived($post, true));
        }

        return response()->json([
            'num' => $post->usersUpvoted()->count()
        ]);
    }

    public function follow(Request $request, Post $post) {
        $this->authorize('follow', $post);

        $user = Auth::user();
        if($user->hasFollowedPost($post)) {
            $user->followedPosts()->detach($post);
            return response()->json([
                'text' => 'Follow',
                'svg' => '<use xlink:href="' . asset('assets/sprite.svg#icon-heart-empty') . '"></use>'
            ]);
        }
        else {
            $user->followedPosts()->attach($post);
            return response()->json([
                'text' => 'Unfollow',
                'svg' => '<use xlink:href="' . asset('assets/sprite.svg#icon-heart-full') . '"></use>'
            ]);
        }
    }

    public function search(Request $request) {
        $request->session()->flashInput($request->all());

        $posts = Post::with([
            'tags',
            'user'
        ])->withCount([
            'usersUpvoted',
            'replies',
            'tags'
        ]);

        if($request->input('post-type')) {
            $posts = $posts->whereIn('posts.post_type_id', $request->input('post-type'));
        }

        if($request->input('search-by') == 'keywords') {
            $posts = $posts
                        ->join('users', 'users.id', '=', 'posts.user_id')
                        ->where(function($query) use($request) {
                            $query->where('posts.title', 'like', "%{$request->input('keyword')}%")
                            ->orWhere('users.first_name', 'like', "%{$request->input('keyword')}%")
                            ->orWhere('users.last_name', 'like', "%{$request->input('keyword')}%");
                        });
        }
        else if($request->input('search-by') == 'tags' && $request->input('tags')) {
            $posts = $posts->join('post_tag', 'post_tag.post_id', '=', 'posts.id')
            ->join('tags', 'tags.id', '=', 'post_tag.tag_id')
            // todo: needs to be modified (need to check all the tags in the input are of this post)
            ->whereIn('tags.id', $request->input('tags'))
            ->distinct();
        }

        // default sorting method is by popularity
        if($request->input('post-sort-by') == 'time') {
            $posts = $posts->orderBy('posts.created_at', 'DESC');
        }
        else {
            $posts = $posts->orderByRaw(POST::POPULARITY_FORMULA . ', created_at DESC');
        }

        $posts = $posts->paginate(self::$POSTS_PER_PAGE);

        return view('forum.index', [
            'trendingTags' => Tag::getTrendingTags(),
            'posts' => $posts,
            'pageTitle' => 'Forum - Search Results',
            'youMayHelpWithPosts' => \Facades\App\Post::getYouMayHelpWith(),
            'hasFilter' => true
        ]);
    }


    public function indexPopular() {
        return view('forum.index', [
            'trendingTags' => Tag::getTrendingTags(),
            'posts' => Post::with([
                            'tags',
                            'user'
                        ])
                        ->withCount([
                            'usersUpvoted',
                            'replies',
                            'tags'
                        ])
                        // todo: modify the formula
                        ->orderByRaw(POST::POPULARITY_FORMULA)
                        ->take(30)
                        ->get()
                        ->paginate(self::$POSTS_PER_PAGE),
            'pageTitle' => 'Forum - Popular Posts',
            'youMayHelpWithPosts' => \Facades\App\Post::getYouMayHelpWith()
        ]);
    }

    public function indexLatest() {
        return view('forum.index', [
            'trendingTags' => Tag::getTrendingTags(),
            'posts' => Post::with([
                            'tags',
                            'user'
                        ])
                        ->withCount([
                            'usersUpvoted',
                            'replies',
                            'tags'
                        ])
                        ->whereDate('created_at', '>=', Carbon::now()->subDays(60))
                        ->orderBy('created_at', 'desc')
                        ->paginate(self::$POSTS_PER_PAGE),
            'pageTitle' => 'Forum - Latest Posts',
            'youMayHelpWithPosts' => \Facades\App\Post::getYouMayHelpWith()
        ]);
    }

}
