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
use App\Session as Session;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Notifications\PayoutPaid;
use App\CustomClass\TimeFormatter;
use App\Notifications\InvoicePaid;

use Illuminate\Support\Facades\DB;
use App\Events\SessionReviewPosted;
use App\Notifications\PayoutFailed;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Notifications\EmailVerification;
use App\Notifications\InvoicePaymentFailed;
use App\Notifications\UnpaidInvoiceReminder;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RefundDeclinedNotification;
use App\Notifications\TutorVerificationNotification;
use App\Http\Controllers\Payment\StripeApiController;
use App\Notifications\UserRequestedRefundNotification;
use App\Notifications\RefundRequestApprovedNotification;
use App\Notifications\Forum\MarkedAsBestReplyNotification;

class testController extends Controller
{
    public function __construct() {

    }

    public function index(Request $request) {
        // event(new SessionReviewPosted(Session::find('7baa7861-040e-40c5-8d4b-846b96d79689'), 5));

        // $ip = file_get_contents("http://ipecho.net/plain");
        //         $url = 'http://ip-api.com/json/'.$ip;
        //         $tz = file_get_contents($url);
        //         $tz = json_decode($tz,true)['timezone'];
        // echo ($ip);
        // geoip($ip = null);
        $userLocation = geoip()->getLocation();
        $timezone = $userLocation['timezone'];
        // echo $timezone;

         $startTime = Carbon::now()->setTimeZone($timezone);
         echo $startTime;
        // $endTime = Carbon::now()->format('Y-m-d');
    //    echo Post::getViewCntWeek(Auth::user()->id);
    }

    public function test(Request $request) {
        $trendingTags = Tag::withCount([
            'posts'
        ])
        ->with([
            'posts' => function($query) {
                $query->withCount('replies');
            }
        ])
        ->orderBy('posts_count', 'desc')
        ->get();

        //Stores the current day
        $current = Carbon::now();
        foreach($trendingTags as $trendingTag) {
            //Stores the number of days since the latest post for a particular tag was created
            $trendingTag->created_at_score =
                $trendingTag->posts()
                ->select('created_at')
                ->orderBy('created_at', 'DESC')
                ->first()
                ->created_at
                ->diffInDays($current) + 1;
            //Stores the number of replies for each tag
            $trendingTag->replies_count =
                $trendingTag->posts->reduce(
                    function ($count, $post) {
                        return $count + $post->replies_count;
                    }, 0
                );
        }
        echo $trendingTags
                ->sortByDesc(
                    function($value, $key) {
                        /* Since the created_at value is inversely proportional to the ranking i.e the lesser the value of
                        created_at the more weightage should be applied to the corresponding tag's trend */
                        return $value["posts_count"] * 2 + $value["replies_count"] * 1.3 / $value['created_at_score'];
                    })
                ->take(5);


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
