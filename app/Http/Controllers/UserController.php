<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AddCreditRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\SignupRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function signup(SignupRequest $request)
    {
        $credentials = $request->validated();
        $credentials['password'] = bcrypt($credentials['password']);
        $user = User::create($credentials);
        return response($user, 201);
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials)) {
            return response(['message' => 'Login successful!'], 200);
        }
        return response(['message' => 'Invalid credentials!'], 403);
    }

    public function addCredit(AddCreditRequest $request){
        $credit = $request->validated()['credit'];
        $user = $request->user();
        $user->credit += $credit;
        $user->save();
        return $user;
    }
}
