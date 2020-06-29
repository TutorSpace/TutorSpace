<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;
use App\Notifications\EmailSubscription;
use Illuminate\Support\Facades\Notification;

class SubscriptionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'email:rfc',
                'unique:subscriptions,email'
            ]
        ]);

        Subscription::create($request->all());

        Notification::route('mail', $request->input('email'))
            ->notify(new EmailSubscription('Visitor', $request->input('email')));

        return response()->json([
            'successMsg' => 'You successfully subscribed!'
        ]);
    }

    public function destroy(Request $request) {
        $email = $request->email;
        Subscription::where('email', $email)->firstOrFail()->delete();

        return redirect()->route('index')->with([
            'successMsg' => 'You have successfully unsubscribed from our email list!'
        ]);
    }


}
