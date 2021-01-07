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
    public function __construct($tutorId, $studentId)
    {
        //
        $this->tutorId = $tutorId;
        $this->studentId = $studentId;
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

        $time = TimeFormatter::getTime($value, $value);
        // check if there's any overlap
        // return true if count == 0, else false
        return Session::where('session_time_start', '<=', $time)
            ->where('session_time_end','>=', $time)
            // either student or tutor
            ->where(function ($query) {
                $query->where('tutor_id', '=', $this->tutorId)
                      ->orWhere('student_id', '=', $this->studentId);
            })
            ->count() == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The validation error message.';
    }
}
