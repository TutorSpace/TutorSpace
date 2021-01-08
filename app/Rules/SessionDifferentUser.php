<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\User;
use Auth;

class SessionDifferentUser implements Rule
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
        //
        $tutor = User::find($value);
        $student = Auth::user();

        return $tutor->email != $student->email;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Same user cannot be student/tutor at the same time';
    }
}
