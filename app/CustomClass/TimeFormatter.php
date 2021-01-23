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
        $ip = file_get_contents("http://ipecho.net/plain");

        return Cache::remember(
            'TIME_FORMATTER-IP-' . $ip,
            3600,
            function() use($ip) {
                $url = 'http://ip-api.com/json/'.$ip;
                $tz = file_get_contents($url);
                $tz = json_decode($tz,true)['timezone'];
                return $tz;
            }
        );

    }

    // todo: modify this, as the session can have muiltiple days!
    // important: make sure the time is already parsed as a carbon object
    public static function getTimeForCalendarWithHours($time, $hours) {
        $substr = ':' . explode(':', $time)[1];

        $hourInt = (int)($time->format('H'));

        if($hourInt == 0) $hourInt = 24;

        $hourInt += $hours;

        $hourInt = max(8, $hourInt);
        $hourInt = min(24, $hourInt);

        if($hourInt < 10) $result = '0' . $hourInt . $substr;
        else $result = '' . $hourInt . $substr;

        return $result;
    }

}
