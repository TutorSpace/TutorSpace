<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Characteristic;

class characteristicController extends Controller
{
    public function removeCharacteristic(Request $request) {
        $characteristicId = $request->input('characteristic_id');

        $user = Auth::user();
        $user->characteristics()->detach($characteristicId);

        return response()->json([
            'successMsg' => 'Successfully removed from your characteristics!'
        ]);
    }

    public function addCharacteristic(Request $request) {
        $request->validate([
            'characteristic' => [
                'required'
            ]
        ]);

        $characteristicInput = $request->input('characteristic');

        $user = Auth::user();

        // trim the user's data and capitalize each words
        $characteristicInput = ucwords(strtolower(trim($characteristicInput)));

        // check whether use's data is already inside the database
        $characteristic = Characteristic::where('characteristic', '=', $characteristicInput)->first();


        if($characteristic) {
            $characteristicId = $characteristic->id;

            // if exist, and user does not faved that characteristic, fav it
            if(!$user->favedCharacteristic($characteristicId)) {
                $user->characteristics()->attach($characteristicId);
                return redirect('profile')->with([
                    'success' => 'Successfully added to your characteristics!'
                ]);
            }

            // if exist, but user faved that characteristic, return error
            return redirect('profile')->with([
                'error' => 'The characteristic you added is already listed in your characteristics!'
            ]);
        }

        // if not exist, add to database and fav this course
        $addCharacteristic = new Characteristic();
        $addCharacteristic->characteristic = $characteristicInput;
        $addCharacteristic->save();

        $user->characteristics()->attach($addCharacteristic->id);

        return redirect('profile')->with([
            'success' => 'Successfully added to your characteristics!'
        ]);
    }

}
