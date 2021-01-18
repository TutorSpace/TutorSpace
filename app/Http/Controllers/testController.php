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
use App\Session as AppSession;
use App\Subject;
use App\Bookmark;
use App\Chatroom;
use Carbon\Carbon;
use App\TutorLevel;
use App\Transaction;
use App\TutorRequest;

use Facades\App\Post;
use App\PaymentMethod;
use App\Characteristic;
use App\Events\NewMessage;
use App\CourseVerification;
use App\Events\NewChatroom;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\PayoutPaid;
use App\Notifications\InvoicePaid;
use Illuminate\Support\Facades\DB;
use App\Notifications\PayoutFailed;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use App\Notifications\EmailVerification;

use App\Notifications\InvoicePaymentFailed;
use App\Notifications\UnpaidInvoiceReminder;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RefundDeclinedNotification;
use App\Notifications\TutorVerificationNotification;
use App\Http\Controllers\payment\StripeApiController;
use App\Notifications\UserRequestedRefundNotification;
use App\Notifications\RefundRequestApprovedNotification;
use App\Notifications\Forum\MarkedAsBestReplyNotification;

class testController extends Controller
{
    public function __construct() {

    }

    public function index(Request $request) {
        // echo Auth::id();
        $prevLevel = TutorLevel::where("level_experience_upper_bound", 30)->first();
        // Auth::user()->addExperience(10000);
        //  Auth::user()->cancelSessionExperienceDeduction();
        echo Auth::user()->experience_points;

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
        // $tutor = User::find(10);
        // $bonus_rate = $tutor->getUserBonusRate();
        // $transaction = Transaction::find(4);
        // echo $transaction->amount * $bonus_rate;
        // if ($bonus_rate > 0) {
        //     app(StripeApiController::class)->createSessionBonus(round($transaction->amount * $bonus_rate), $transaction->session);
        // }
        // app(StripeApiController::class)->checkIfCardAlreadyExists();
        // Auth::user()->cancelSessionExperienceDeduction();
        // $lastAction = Session::get("lastBankCardAction");

        // if (!Session::has('lastBankCardAction')){
        //     echo "nothing";
        // }
        // Auth::user()->storeBankCardActionInSession("addNewa");
        // echo Session::get("lastBankCardAction");
        // dump(Session::get("bankCards"));

        // $user->notify(new RefundDeclinedNotification($session));

        // echo $prevLevel->level_experience_upper_bound;
    }

}
