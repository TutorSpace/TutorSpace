<?php
namespace App\CustomClass;

class TimeFormatter {
    public function getTime($date, $time) {
        $time = date("H:i:s", strtotime($time));
        $date = date('Y-m-d', strtotime($date));
        return "$date $time";
    }

}
