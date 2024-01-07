<?php


namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthContoller extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $user = User::query()
            ->where('email', '=', $request->email)
            ->first();

        if (empty($user) || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'Unauthorized'
            ], 401);
        }

        $token = $user->currentAccessToken() ?: $user->createToken(str()->random(64));

        return response()->json([
            'access_token' => $token->plainTextToken,
            'user' => $user,
        ]);
    }
    public function register(UserRequest $request): JsonResponse
    {
        $user = User::query()->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json(['user' => $user], 200);
    }
    public function get(Request $request)
    {

        $token = PersonalAccessToken::findToken($request->bearerToken());
        $user = $token->tokenable;

        return response()->json([
            'user' => $user,
        ]);
    }
}
