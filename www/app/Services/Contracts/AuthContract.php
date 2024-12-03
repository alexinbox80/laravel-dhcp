<?php

namespace App\Services\Contracts;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Requests\Auth\RefreshTokenRequest as HttpRequest;

interface AuthContract
{
    public function login(LoginRequest $loginRequest): array;

    public function logOutUser(): void;

    public function resetPassword(ResetPasswordRequest $resetPasswordRequest): array;

    public function register(RegisterRequest $registerRequest): array;

    public function refreshToken(HttpRequest $request): array;
}
