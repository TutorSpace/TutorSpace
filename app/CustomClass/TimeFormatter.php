<?php
namespace App\CustomClass;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class TimeFormatter {

    public static function getTime($date, $time) {
        $time = date("H:i:s", strtotime($time));
        $date = date('Y-m-d', strtotime($date));
        return "$date $time";
    }

    public static function getDate($date){
        $date = date('Y-m-d', strtotime($date));
        return "$date";
    }

    /*
    Reference: https://medium.com/@mrrudrud/get-users-local-timezone-with-laravel-5-x-c1cd658815bd
    */
    // Get User's Geolocation
    public static function getTZ() {
        $userLocation = geoip()->getLocation();
        $timezone = $userLocation['timezone'];
        return $timezone;
    }

    public static function getTZShortHand($tz) {
        $time = explode('/', $tz);
        return $time[count($time) - 1];
    }
}
