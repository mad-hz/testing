<?php

namespace App\Mentions;

use App\Models\User;

class Mentionables
{
    /**
     * @return map list of users to mentions
     */
    public static function get()
    {
        return User::get()->map(fn(User $user) => [
            'key' => $user->name,
            'value' => $user->username,
            'id' => $user->id
        ]);
    }
}
