<?php
namespace App\CustomClass;

class TimeOverlapManager {

  //take the user input as $startTime and $endTime,
  //compares it with the tutor's time -
  //$availableTimeStart and $availableTimeEnd and RETURNS TRUE IF THERE IS NO OVERLAP
    public static function noTimeOverlap($startTime, $endTime, $availableTimeStart, $availableTimeEnd) {
        return ($endTime <= $availableTimeStart) || ($availableTimeEnd <= $startTime);
    }
}
