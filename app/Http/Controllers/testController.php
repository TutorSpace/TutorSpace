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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Notifications\EmailVerification;

use App\Notifications\InvoicePaymentFailed;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TutorVerificationNotification;

use App\Http\Controllers\payment\StripeApiController;
use App\Notifications\Forum\MarkedAsBestReplyNotification;

class testController extends Controller
{
    public function __construct() {

    }

    public function index(Request $request) {
        // Auth::user()->addExperience(10000);
        Auth::user()->notify(new InvoicePaymentFailed(Session::find('957de7ab-0037-4bc6-bdec-88e26daa9660')));
    }

}
