<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['register']]);
    }
    public function register(RegisterUserRequest $request){
        $user = User::create([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'gender' => $request->get('gender'),
        ]);

        $token = auth()->attempt(['email' => $request->get('email'), 'password' => $request->get('password')]);

        return response()->json([$token, $user], 201)
            ->cookie('token', $token, 60 * 24, '/', null, true, true);
    }

    public function me()
    {
        $user = auth()->user();
        unset($user['created_at']);
        unset($user['updated_at']);
        return response()->json($user);
    }
}
