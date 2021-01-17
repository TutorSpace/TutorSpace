<?php

namespace App\Http\Controllers;

use App\Session;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Payment\StripeApiController;

class NotificationController extends Controller
{
    public function index() {
        return view('notification.index');
    }

    public function show(Request $request, $notifId) {
        $notif = Auth::user()->notifications()->firstWhere('id', $notifId);

        if($notif->type == 'App\Notifications\WelcomeMessageNotification') {
            $view = view(
                Auth::user()->is_tutor ? 'notification.content.tutorspace.welcome-msg-tutor' : 'notification.content.tutorspace.welcome-msg-student', [])->render();
        } else if($notif->type == 'App\Notifications\TutorVerificationInitiatedNotification') {
            $view = view(
                'notification.content.tutorspace.tutor-verification-initiated', [])->render();
        } else if($notif->type == 'App\Notifications\TutorVerificationCompleted') {
            $view = view(
                'notification.content.tutorspace.tutor-verification-processed', [])->render();
        } else if($notif->type == 'App\Notifications\InvoicePaymentFailed') {
            $view = view(
                'notification.content.tutorspace.payment-fail', [
                    'paymentUrl' => app(StripeApiController::class)->getPaymentUrl(Session::find($notif->data['session']['id'])),
                    'session' => Session::find($notif->data['session']['id'])
                ])->render();
        } else if($notif->type == 'App\Notifications\InvoicePaid') {
            $view = view(
                'notification.content.tutorspace.invoice-success', [
                    'session' => Session::find($notif->data['session']['id'])
                ])->render();
        } else if($notif->type == 'App\Notifications\TutorLevelUpNotification') {
            $view = view(
                'notification.content.tutorspace.tutor-level-up', [
                    'currLevel' => $notif->data['currLevel'],
                    'nextLevel' => $notif->data['nextLevel'],
                    'levelProgressPercentage' => $notif->data['levelProgressPercentage']
                ])->render();
        }

        $notif->markAsRead();

        return response()->json([
            'view' => $view
        ]);
    }
}
