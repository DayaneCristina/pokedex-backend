<?php

namespace App\Repositories;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function register(UserDTO $userDTO) : void
    {
        User::create([
            'name'     => $userDTO->getName(),
            'email'    => $userDTO->getEmail(),
            'password' => Hash::make($userDTO->getPassword()),
        ]);
    }
}
