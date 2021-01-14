<?php

namespace App\Http\Controllers;

use Auth;

use App\Tag;
use App\Test;
use App\User;
use App\View;
use App\Reply;
use App\Course;
use App\Message;
use App\Session;
use App\Subject;
use App\Bookmark;
use App\Chatroom;
use App\Transaction;
use App\PaymentMethod;
use App\TutorLevel;
use Carbon\Carbon;

use App\TutorRequest;
use Facades\App\Post;
use App\Characteristic;
use App\Events\NewMessage;
use App\CourseVerification;
use App\Events\NewChatroom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Notifications\EmailVerification;

use Illuminate\Support\Facades\Notification;
use App\Notifications\TutorVerificationNotification;
use App\Notifications\Forum\MarkedAsBestReplyNotification;

use App\Http\Controllers\payment\StripeApiController;

class testController extends Controller
{
    public function __construct() {

    }

    public function index(Request $request) {

        dd(User::find(5)->numStudents());

        return view('test');
    }

    public function test(Request $request) {

        // Auth::user()->tutorHasStripeAccount();
        // echo Auth::user()->firstMajor->id;
        // $transactionsToCharge = Transaction::join("sessions","sessions.id","=","transactions.session_id") // join

        // ->whereRaw("TIMESTAMPDIFF (MINUTE, sessions.session_time_end, '" . Carbon::now() . "' ) >= ?", 0) // ? minutes after session end
        // ->where("transactions.invoice_status","draft") // invoice status => draft
        // ->where("sessions.is_canceled",0) // not canceled
        // ->get();

        // echo $transactionsToCharge->count();
        // Auth::user()->addExperience(10000);
        $tutor = User::find(10);
        $bonus_rate = $tutor->getUserBonusRate();
        $transaction = Transaction::find(4);
        echo $transaction->amount * $bonus_rate;
        if ($bonus_rate > 0) {
            app(StripeApiController::class)->createSessionBonus(round($transaction->amount * $bonus_rate), $transaction->session);
        }
    }
}
