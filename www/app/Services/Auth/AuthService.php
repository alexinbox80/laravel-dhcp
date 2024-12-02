<?php

namespace App\Services\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use App\Services\Contracts\AuthContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class AuthService implements AuthContract
{
    public function login(LoginRequest $loginRequest): array
    {
        $loginRequest->validated();

        if (Auth::attempt(['email' => $loginRequest->email, 'password' => $loginRequest->password])) {
            $user = Auth::user();

            $accessToken = $user->createToken('AccessToken');

            $success['access_token'] = $accessToken->accessToken;
            $success['token_type'] = 'Bearer';
            $success['expires_at'] = Carbon::parse(
                $accessToken->token->expires_at
            )->toDateTimeString();

            $user->save();

            return $success;
        } else {
            return [];
        }
    }

    public function logOutUser(): void
    {
        auth()->user()->tokens()->delete();
    }

    public function resetPassword(ResetPasswordRequest $resetPasswordRequest): array
    {
        $resetPasswordRequest->validated();

        $user['account'] = User::update([
            'email' => $resetPasswordRequest->email,
        ], [
            'name' => 'test',
            'password' => Hash::make($resetPasswordRequest->password)
        ]);

        $accessToken = $user->createToken('AccessToken');

        $success['access_token'] = $accessToken->accessToken;
        $success['token_type'] = 'Bearer';
        $success['expires_at'] = Carbon::parse(
            $accessToken->token->expires_at
        )->toDateTimeString();

        return $success;
    }

    public function register(RegisterRequest $registerRequest): array
    {
        $registerRequest->validated();

        $user['account'] = User::create([
            'name' => 'test',
            'email' => $registerRequest->email,
            'password' => Hash::make($registerRequest->password)
        ]);

        if (Auth::attempt(['email' => $user['account']->email, 'password' => $user['account']->password])) {
            $user = Auth::user();
            $accessToken = $user['account']->createToken('AccessToken');
            $success['id'] = $user['account']->id;
            $success['email'] = $user['account']->email;
            $success['access_token'] = $accessToken->accessToken;
            $success['token_type'] = 'Bearer';
            $success['expires_at'] = Carbon::parse(
                $accessToken->token->expires_at
            )->toDateTimeString();

            return $success;
        } else
            return [];
    }

    public function refreshToken(\Illuminate\Http\Request $request): array
    {
        $request = Request::create('http://dhcpw:88/oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
        ]);

        //dd($request);

        $result = app()->handle($request);
        $response = json_decode($result->getContent(), true);

        dd($response);
        //return response()->json($response, 200);

        return [];
//        return response()->json([
//            'success' => true,
//            'statusCode' => 200,
//            'message' => 'Refreshed token.',
//            'data' => $response->json(),
//        ], 200);
    }
}
