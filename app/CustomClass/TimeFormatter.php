<?php
namespace App\CustomClass;

use Illuminate\Support\Facades\Log;

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
