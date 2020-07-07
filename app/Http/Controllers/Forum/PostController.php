<?php

namespace App\Http\Controllers\Forum;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct() {
        $this->middleware(['auth'])->only(['create', 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('forum.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('forum.create');
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
            'hourly-rate' => [
                'required',
                'numeric',
                'min:10',
                'max:50'
            ],
            'courses' => [
                'required',
                'array',
                'min:1'
            ],
            'courses.*' => [
                'exists:courses,id'
            ]
        ]);


        return view('test', [
            'postContent' => $request->input('post-content')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        return view('forum.my_follows');
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
                'errorMsg' => 'Something went wrong when uploading the image...'
            ]);
        }
    }
}
