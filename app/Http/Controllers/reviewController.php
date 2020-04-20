<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Session;
use App\Review;

class reviewController extends Controller
{
    public function postReview(Request $request) {
        $reviewContent = $request->input('reviewMsg');
        $sessionId = $request->input('sessionId');
        $rating = $request->input('rating');

        $user = Auth::user();
        $revieweeId;
        $reviewerId;
        $session = Session::find($sessionId);

        if($user->is_tutor) {
            $revieweeId = $session->student_id;
            $reviewerId = $session->tutor_id;
        }
        else {
            $revieweeId = $session->tutor_id;
            $reviewerId = $session->student_id;
        }

        $review = new Review();
        $review->reviewer_id = $reviewerId;
        $review->reviewee_id = $revieweeId;
        $review->session_id = $sessionId;
        $review->star_rating = $rating;
        $review->review = $reviewContent;
        $review->save();


        return response()->json(
            [
                'successMsg' => 'Successfully made the review!'
            ]
        );
    }
}
