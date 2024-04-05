<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $expiration = now()->addMonths(3);
        $token = $user->createToken('auth_token', ['*'], $expiration)->plainTextToken;

        return response()->json([

            'accessToken' => $token,
            'token_type' => 'Bearer',
            'expires_at' => $expiration->toDateTimeString(),
        ]);
    }

    public function login(AuthLoginRequest $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {

            $user = User::where('email', $request->email)->first();
            $expiration = now()->addMonths(3);
            $token = $user->createToken('auth_token', ['*'], $expiration)->plainTextToken;

            return response()->json([
                'accessToken' => $token,
                'token_type' => 'Bearer',
                'expires_at' => $expiration->toDateTimeString(),
            ]);
        }
    }

    public function logout(Request  $request)
    {

        $request->user()->tokens()->delete();

        return [
            'message' => 'Successful logout.'
        ];
    }
}
