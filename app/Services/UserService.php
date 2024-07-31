<?php

namespace App\Services;

use App\DTO\UserDTO;
use App\Repositories\UserRepository;

class UserService
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function register(UserDTO $userDTO) : void
    {
        $this->repository->register($userDTO);
    }
}
