<?php

namespace App\Http\Controllers;

use App\DTO\UserDTO;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $this->service->register(new UserDTO(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        ));

        return response()
            ->json([], 204);
    }
}
