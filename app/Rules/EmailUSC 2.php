<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailUSC implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        // todo: remove ucsd
        if(explode("@", $value)[1] !== 'usc.edu' && explode("@", $value)[1] !== 'ucsd.edu')
            return false;
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Your email must be a USC email.';
    }
}
