<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class TagRule implements Rule
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
        if(empty($value)){
            return true;
        }
        $value = str_replace('、', ',', $value);
        $count_word = substr_count($value, ",");
        $result = ($count_word <= 5) ? true : false;
        return $result;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'タグは最大5コまでです。';
    }
}
