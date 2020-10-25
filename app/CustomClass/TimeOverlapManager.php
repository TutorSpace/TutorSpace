<?php
namespace App\CustomClass;

class TimeOverlapManager {

  //take the user input as $startTime and $endTime,
  //compares it with the tutor's time -
  //$availableTimeStart and $availableTimeEnd and RETURNS TRUE IF THERE IS NO OVERLAP
    // edge case: if one ends at 5pm while the other starts at 5pm, then there is no overlap.
    public static function noTimeOverlap($startTime, $endTime, $availableTimeStart, $availableTimeEnd) {
        return ($endTime <= $availableTimeStart) || ($availableTimeEnd <= $startTime);
    }
}
