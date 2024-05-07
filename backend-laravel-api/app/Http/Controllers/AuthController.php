<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Tag(
 *     name="Auth Controller",
 *     description="Endpoints related to authentication"
 * )
 */

class AuthController extends Controller
{

    /**
     * 
     * @OA\Post(
     *     path="/api/register",
     *     summary="Register a new user",
     *      tags={"Auth Controller"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="name", type="string", example="test register"),
     *                 @OA\Property(property="email", type="string", example="register@example.com"),
     *                 @OA\Property(property="password", type="string", example="123456789"),
     *             )
     *         )
     *     ),
     * 
     *     @OA\Response(
     *         response="201",
     *         description="User registered successfully"
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation errors"
     *     )
     * )
     */
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
        ], 201);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Authenticate user and generate JWT token",
     *     tags={"Auth Controller"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="email", type="string", example="john@example.com"),
     *                 @OA\Property(property="password", type="string", example="123456789"),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="accessToken", type="string"),
     *             @OA\Property(property="token_type", type="string", example="Bearer"),
     *             @OA\Property(property="expires_at", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Invalid credentials"
     *     )
     * )
     */
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
            ], 200);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }
    /**
     * @OA\Post(
     *     path="/api/logout",
     *     summary="Logout user and revoke all tokens",
     *     tags={"Auth Controller"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successful logout"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function logout(Request  $request)
    {

        $request->user()->tokens()->delete();

        return [
            'message' => 'Successful logout.'
        ];
    }
}
