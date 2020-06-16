<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;

class AuthenticationController extends Controller
{

    public function register()
    {
        $validatedData = request()->validate([
            'name' => ['required', 'string', 'regex:/^[A-Za-z][A-Za-z0-9]{4,31}$/', 'max:20', 'min:5', 'alpha_num', 'unique:users,name'],
            'email' => 'email|required|unique:users',
            'password' => 'required|min:6|max:30'
        ]);

        $validatedData['password'] = bcrypt(request()->password);

        $user = User::create($validatedData);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);
    }

    public function login()
    {
        $loginData = request()->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response(['message' => 'Invalid Credentials'], 403);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);
    }

    public function user(User $user)
    {
        return response(['data' => $user, 'message' => 'success'], 200);
    }

}
