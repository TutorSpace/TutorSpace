<?php

namespace App\Http\Controllers;

use App\User;
use App\Session;
use App\Notification;
use App\TutorRequest;
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
        } else if($notif->type == 'App\Notifications\UnpaidInvoiceReminder') {
            $view = view(
                'notification.content.tutorspace.payment-fail-again', [
                    'paymentUrl' => app(StripeApiController::class)->getPaymentUrl(Session::find($notif->data['session']['id'])),
                    'session' => Session::find($notif->data['session']['id']),
                ])->render();
        } else if($notif->type == 'App\Notifications\PayoutFailed') {
            $view = view(
                'notification.content.tutorspace.payout-failed', [
                    'failureCode' => $notif->data['failureCode'],
                ])->render();
        } else if($notif->type == 'App\Notifications\PayoutPaid') {
            $view = view(
                'notification.content.tutorspace.payout-success', [
                    'amount' => $notif->data['amount']
                ])->render();
        } else if($notif->type == 'App\Notifications\InviteToBeTutorNotification') {
            $view = view(
                'notification.content.tutorspace.invite-to-be-tutor', [
                    'user' => User::find($notif->data['user']['id']),
                    'inviteCode' => $notif->data['inviteCode'],
                ])->render();
        } else if($notif->type == 'App\Notifications\UserRequestedRefundNotification') {
            $view = view(
                'notification.content.sessions.refund-request-initiated', [
                    'session' => Session::find($notif->data['session']['id'])
                ])->render();
        } else if($notif->type == 'App\Notifications\RefundRequestApprovedNotification') {
            $view = view(
                'notification.content.sessions.refund-request-success', [
                    'session' => Session::find($notif->data['session']['id'])
                ])->render();
        } else if($notif->type == 'App\Notifications\RefundDeclinedNotification') {
            $view = view(
                'notification.content.sessions.refund-request-fail', [
                    'session' => Session::find($notif->data['session']['id'])
                ])->render();
        } else if($notif->type == 'App\Notifications\NewTutorRequest') {
            $view = view(
                'notification.content.sessions.tutor-request', [
                    'tutorRequest' => TutorRequest::find($notif->data['tutorRequest']['id'])
                ])->render();
        } else if($notif->type == 'App\Notifications\TutorRequestAccepted') {
            $view = view(
                'notification.content.sessions.session-confirmation-student', [
                    'tutorRequest' => TutorRequest::find($notif->data['tutorRequest']['id'])
                ])->render();
        } else if($notif->type == 'App\Notifications\TutorRequestDeclined') {
            $view = view(
                'notification.content.sessions.session-decline', [
                    'tutorRequest' => TutorRequest::find($notif->data['tutorRequest']['id'])
                ])->render();
        } else if($notif->type == 'App\Notifications\CancelSessionNotification') {
            if(Auth::user()->is_tutor) {
                if($notif->data['canceledByTutor']) {
                    $viewName = 'notification.content.sessions.session-cancel-by-tutor';
                } else {
                    $viewName = 'notification.content.sessions.session-cancel-notify-tutor';
                }
            } else {
                if($notif->data['canceledByTutor']) {
                    $viewName = 'notification.content.sessions.session-cancel-notify-student';
                } else {
                    $viewName = 'notification.content.sessions.session-cancel-by-student';
                }
            }

            $view = view(
                $viewName, [
                    'session' => Session::find($notif->data['session']['id']),
                    'expLost' => $notif->data['expLost'],
                ])->render();
        }

        $notif->markAsRead();

        return response()->json([
            'view' => $view
        ]);
    }
}
