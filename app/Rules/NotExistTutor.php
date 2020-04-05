<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;

class NotExistTutor implements Rule
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
        if(User::where('email', '=', $value)->where('is_tutor', true)->count() == 0)
            return true;
            
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This Email is already registered.';
    }
}
