<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use App\NewMessage;
use App\Chatroom;
use App\Message;

class TutorRequestController extends Controller
{


    public function makeTutorRequest(Request $request) {
        $request->validate([
            'start_time' => ['
                required'
            ],
            'end_time' => [
                'required'
            ],
            'tutor_session_date' => [
                'required'
            ],
            'tutor_id' => [
                'required'
            ],
            'subjectCourse' => [
                'required'
            ],
            'message' => [
                'required'
            ]
        ]);
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');
        $date = $request->input('tutor_session_date');
        $tutorId = $request->input('tutor_id');
        $inputCourseSubject = $request->input('subjectCourse');
        $isCourse = explode("-", $inputCourseSubject)[0] === 'course';
        $courseSubjectId = explode("-", $inputCourseSubject)[1];
        $message = $request->input('message');

        $tutorRequest = new Tutor_request();
        $tutorRequest->tutor_id = $tutorId;
        $tutorRequest->student_id = Auth::user()->id;
        if($isCourse) {
            $tutorRequest->is_course_request = 1;
            $tutorRequest->course_id = $courseSubjectId;
        }
        else {
            $tutorRequest->is_course_request = 0;
            $tutorRequest->subject_id = $courseSubjectId;
        }
        $tutorRequest->tutor_session_date = $date;
        $tutorRequest->message_to_tutor = $message;
        $tutorRequest->start_time = $startTime;
        $tutorRequest->end_time = $endTime;
        $tutorRequest->save();

        // sending the message to the tutor
        $user = Auth::user();
        $myId = $user->id;

        $haveChattingRoom = Chatroom::where(function($query) use($myId, $tutorId) {
            $query->where('user_id_1', $myId)->where('user_id_2', '=', $tutorId);
        })
        ->orWhere(function($query) use($myId, $tutorId) {
            $query->where('user_id_2', $myId)->where('user_id_1', '=', $tutorId);
        })
        ->count() != 0;

        // if there's no chatting room between the student and the tutor yet, create a room
        if(!$haveChattingRoom) {
            $chatroom = new Chatroom();
            $chatroom->user_id_1 = $user->id;
            $chatroom->user_id_2 = $tutorId;
            $chatroom->save();
        }


        // save message to the database
        $data = new Message();
        $data->from = $user->id;
        $data->to = $tutorId;
        $data->message = $message;
        $data->is_read = 0;
        $data->save();


        // sending the message
        $msg = [
            'from' => $data->from,
            'to' => $data->to,
            'msg' => $message,
            'time' => $data->created_at,
            'newTutorRequest' => true
        ];
        event(new NewMessage($msg));


        return response()->json([
            'successMsg' => 'Successfully make the tutor request!'
        ]);
    }



}
