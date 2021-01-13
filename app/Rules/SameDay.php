<?php

namespace App\Rules;
use App\CustomClass\TimeFormatter;
use Illuminate\Contracts\Validation\Rule;

class SameDay implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $otherTime;
    public function __construct($otherTime)
    {
        //
        $this->otherTime = TimeFormatter::getDate($otherTime);
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
        $curTime = TimeFormatter::getDate($value);
        // return true if they are same day
        return $curTime == $this->otherTime;
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
