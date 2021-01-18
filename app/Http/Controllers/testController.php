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
        echo Auth::id();

        $session = Session::find('fb25b945-f2d4-4587-9683-eabe0d401d73');
        $user = User::find('04c9b829-f027-4ff2-a4ea-0410ba684134');

        $user->notify(new RefundDeclinedNotification($session));
    }

}
