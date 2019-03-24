<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidCard implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {

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
        if (!empty($value) && strlen($value)  == 20 && ((int)$value[0]+(int)$value[9]) == ((int)$value[1]+(int)$value[19])){
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Card not valid.';
    }
}
