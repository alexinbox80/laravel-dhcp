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
use Illuminate\Http\Request as HttpRequest;

class AuthService implements AuthContract
{
    public function login(LoginRequest $loginRequest): array
    {
        $loginRequest->validated();

        if (Auth::attempt(['email' => $loginRequest->email, 'password' => $loginRequest->password])) {
            $user = Auth::user();

            $accessToken = $user->createToken('AccessToken');

            $success['access_token'] = $accessToken->accessToken;
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

        if(Hash::check($resetPasswordRequest->oldPassword, auth()->user()->password)
            && ($resetPasswordRequest->email === auth()->user()->email)) {

            User::where('email', $resetPasswordRequest->email)
                ->update([
                    'name' => 'test',
                    'password' => Hash::make($resetPasswordRequest->password)
                ]);

            $user = Auth::user();

            $accessToken = $user->createToken('AccessToken');

            $success['access_token'] = $accessToken->accessToken;
            $success['expires_at'] = Carbon::parse(
                $accessToken->token->expires_at
            )->toDateTimeString();


            return $success;
        }

        return [];
    }

    public function register(RegisterRequest $registerRequest): array
    {
        $registerRequest->validated();

        $user['account'] = User::create([
            'name' => 'test',
            'email' => $registerRequest->email,
            'password' => Hash::make($registerRequest->password)
        ]);

        if (Auth::attempt(['email' => $user['account']->email, 'password' => $registerRequest->password])) {
            $user = Auth::user();
            $accessToken = $user->createToken('AccessToken');
            $success['id'] = $user->id;
            $success['email'] = $user->email;
            $success['access_token'] = $accessToken->accessToken;
            $success['expires_at'] = Carbon::parse(
                $accessToken->token->expires_at
            )->toDateTimeString();

            return $success;
        } else
            return [];
    }

    public function refreshToken(HttpRequest $request): array
    {
        $request = Request::create('oauth/token', 'POST', [
            'grant_type' => 'password',
            'client_id' => env('CLIENT_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'username' => $request->email,
            'password' => $request->password,
            'scope' => '',
        ]);

        $result = app()->handle($request);
        return json_decode($result->getContent(), true);
    }
}
