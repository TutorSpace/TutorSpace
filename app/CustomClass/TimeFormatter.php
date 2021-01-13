<?php
namespace App\CustomClass;

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
}
