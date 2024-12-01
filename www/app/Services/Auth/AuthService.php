<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Services\Contracts\AuthContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService implements AuthContract
{
    public function resetPassword(Request $request): array
    {
        //$user = User::where('email', $request->email)->first();

        DB::table('users')
            ->where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);
        return [
            'status' => true,
            'body' => [
                'message' => __('passwords.reset'),
            ],
        ];
    }

    public function register(Request $request): array
    {
        $request->validate([
            'email' => ['required', 'email', 'unique:users,email', 'max:50'],
            'password' => ['required_with:confirmPassword', 'string', 'same:confirmPassword', 'min:8', 'max:24'],
            'confirmPassword' => ['required', 'string', 'min:8', 'max:24']
        ]);

        $user['account'] = User::create([
            'name' => 'test',
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $success['token'] = $user['account']->createToken('AccessToken')->accessToken;

        return [
            'id' => $user['account']['id'],
            'email' => $user['account']['email'],
            'access_token' => $success['token']
        ];
    }

    /*
    public function refreshToken(RefreshTokenRequest $request): JsonResponse
    {
        $response = Http::asForm()->post(env('APP_URL') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $request->refresh_token,
            'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSPORT_PASSWORD_SECRET'),
            'scope' => '',
        ]);

        return response()->json([
            'success' => true,
            'statusCode' => 200,
            'message' => 'Refreshed token.',
            'data' => $response->json(),
        ], 200);
    }
    */
}
