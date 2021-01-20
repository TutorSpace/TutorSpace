<?php

namespace App\Rules;

use App\Session;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\CustomClass\TimeFormatter;

class SessionOverlap implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */

    public $tutorId;
    public $studentId;
    public $startTime;
    public $endTime;

    public function __construct($tutorId, $studentId, $startTime, $endTime)
    {
        //
        $this->tutorId = $tutorId;
        $this->studentId = $studentId;
        $this->startTime = TimeFormatter::getTime($startTime, $startTime);
        $this->endTime = TimeFormatter::getTime($endTime, $endTime);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // check if there's any overlap
        // return true if count == 0, else false
        // if (StartA <= EndB)  and  (EndA >= StartB), then overlap exists
        // https://stackoverflow.com/questions/325933/determine-whether-two-date-ranges-overlap
        return Session::where('session_time_start', '<=',$this->endTime)
            ->where('session_time_end','>=', $this->startTime)
            // either student or tutor
            ->where(function ($query) {
                $query->where('tutor_id', '=', $this->tutorId)
                      ->orWhere('student_id', '=', $this->studentId);
            })
            ->where('is_canceled', false)
            ->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'There is a time conflict for your schedule session.';
    }
}
