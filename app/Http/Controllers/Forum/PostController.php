<?php

namespace App\Http\Controllers\Forum;

use App\Post;
use App\PostType;
use App\PostDraft;
use App\Rules\WordCountGTE;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct() {
        $this->middleware(['auth'])->only([
            'create',
            'store',
            'showMyFollows',
            'showMyPosts',
            'uploadPostImg',
            'storeAsDraft',
            'upvote',
            'follow'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('forum.index', [
            'posts' => Post::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('forum.create', [
            'postDraft' => PostDraft::firstOrNew([
                'user_id' => Auth::user()->id,
            ],[
                'post_type_id' => 0
            ])
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

        $post = new Post();
        $post->title = $request->input('post-title');
        $post->content = $request->input('post-content');
        $post->slug = Str::slug($request->input('post-title'));

        $post->post_type()->associate(PostType::find($request->input('post-type')));
        $post->user()->associate(Auth::user());

        $post->save();

        $post->tags()->attach($request->input('tags'));

        $postDraft = PostDraft::where('user_id', Auth::user()->id)->first();
        if($postDraft) {
            $postDraft->delete();
        }

        return redirect()->route('posts.index')->with([
            'successMsg' => 'You successfully created a new post!'
        ]);
    }

    public function storeAsDraft(Request $request) {
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
        // $post->update([
        //     'view_count' => $post->view_count + 1
        // ]);

        return view('forum.show', [
            'post' => $post
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
    public function destroy($id)
    {
        //
    }

    public function showMyFollows() {
        return view('forum.my_follows', [
            'posts' => Auth::user()->followedPosts
        ]);
    }

    public function showMyPosts() {
        return view('forum.my_posts', [
            'posts' => Auth::user()->posts
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
            $post->update([
                "upvote_count" => $post->upvote_count - 1
            ]);
        }
        else {
            $user->upvotedPosts()->attach($post);
            $post->update([
                "upvote_count" => $post->upvote_count + 1
            ]);
        }

        return response()->json([
            'num' => $post->upvote_count
        ]);
    }

    public function follow(Request $request, Post $post) {
        $user = Auth::user();
        if($user->hasFollowedPost($post)) {
            $user->followedPosts()->detach($post);
            return response()->json([
                'text' => 'Follow'
            ]);
        }
        else {
            $user->followedPosts()->attach($post);
            return response()->json([
                'text' => 'Unfollow'
            ]);
        }
    }
}
