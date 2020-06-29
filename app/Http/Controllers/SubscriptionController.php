<?php

namespace App\Http\Controllers;

use App\Subscription;
use Illuminate\Http\Request;

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

        return response()->json([
            'successMsg' => 'You successfully subscribed!'
        ]);
    }


}
