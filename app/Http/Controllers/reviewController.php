<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class reviewController extends Controller
{
    public function postReview(Request $request) {
        $reviewContent = $request->input('reviewMsg');
        


        return response()->json(
            [
                'successMsg' => 'Successfully cancelled the tutor session!'
            ]
        );
    }
}
