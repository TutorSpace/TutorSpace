<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index() {
        return view('notification.index');
    }

    public function show(Request $request, $notifId) {
        $notif = Auth::user()->notifications()->firstWhere('id', $notifId);

        if($notif->type == 'App\Notifications\WelcomeMessageNotification') {
            $view = view(
                Auth::user()->is_tutor ? 'notification.content.tutorspace.welcome-msg-tutor' : 'notification.content.tutorspace.welcome-msg-student', [

            ])->render();
        }

        $notif->markAsRead();

        return response()->json([
            'view' => $view
        ]);
    }
}
