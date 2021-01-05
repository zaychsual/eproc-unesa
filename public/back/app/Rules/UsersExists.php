<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class UsersExists implements Rule
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
        $user = User::where('email', '=', $value)
            ->where(function ($query) {
                $query->where('is_active', 1);
            })->first();

        if (empty($user))
            return true;
        else
            return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute yang Anda masukkan sudah digunakan. Silakan mendaftar dengan email lain';
    }
}
