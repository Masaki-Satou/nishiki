<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CurrentPassword implements Rule
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
        //attributeにはフィールド名、$valueにはフィールドの値が格納されている

        //ここでfalseがかえると下のmessage()が表示される
        // return password_verify($value,Auth::user()->password);//laravelのHashファサードを使用でもいい
        return Hash::check($value,Auth::user()->password);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '現在のパスワードの値が違います。';
    }
}
