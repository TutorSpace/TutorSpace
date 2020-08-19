<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class WordCountGTE implements Rule
{
    public $lowerLimit;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($lowerLimit)
    {
        $this->lowerLimit = $lowerLimit;
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
        $words = explode(' ', $value);
        $wordCnt = count($words);
        return $wordCnt >= $this->lowerLimit;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Please enter at least ' . $this->lowerLimit . ' words.';
    }
}
