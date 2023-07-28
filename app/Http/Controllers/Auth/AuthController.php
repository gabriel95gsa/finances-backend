<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return response()->json([
            'user' => Auth::user(),
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);

        return $this->respondWithToken($token);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json([
            'message' => 'Logged out',
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        return response()->json(Auth::user());
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        $token = auth('api')->refresh();

        return $this->respondWithToken($token);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {

    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return JsonResponse
     */
    protected function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
