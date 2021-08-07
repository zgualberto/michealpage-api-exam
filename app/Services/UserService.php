<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    /**
     * Create user
     *
     * @param mixed $data
     * @return User;
     */
    public function create($data): User
    {
        return User::create($data);
    }

    /**
     * Get user by user_name
     *
     * @param mixed $data
     * @return User;
     */
    public function find($data): ?User
    {
        return User::where($data)->first();
    }
}
