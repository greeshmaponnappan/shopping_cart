<?php

namespace App\Repository;

use App\Models\User;

class LoginRepository
{
    /**
     * Create a new class instance.
     */
    public function register(array $data)
    {
        return User::create($data); 
    }
}
