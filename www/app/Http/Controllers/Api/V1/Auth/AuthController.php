<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Http\Resources\Auth\AuthApiResource;
use App\Services\Contracts\AuthContract as AuthService;
use App\Services\Contracts\ResponseContract as ResponseService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Auth\RefreshTokenRequest as HttpRequest;

class AuthController extends Controller
{
    public function login(
        AuthService $authService,
        ResponseService $responseService,
        LoginRequest $loginRequest
    ): JsonResponse
    {
        $response = $authService->login($loginRequest);

        if (count($response) > 0) {
            return $responseService->success([AuthApiResource::make($response)]);
        } else {
            return $responseService->unprocessableContent(['message' => __('auth.login.failed')]);
        }
    }

    public function logOutUser(
        AuthService $authService,
        ResponseService $responseService,
    ): JsonResponse
    {
        $authService->logOutUser();

        return $responseService->success(['message' => __('auth.logout.success')]);
    }

    public function resetPassword(
        AuthService $authService,
        ResponseService $responseService,
        ResetPasswordRequest $resetPasswordRequest
    ): JsonResponse
    {
        $response = $authService->resetPassword($resetPasswordRequest);

        if (count($response) === 0) {
            return $responseService->forbidden(['message' => __('auth.reset.password.failed')]);
        }

        return $responseService->success([AuthApiResource::make($response)]);
    }

    public function register(
        AuthService $authService,
        ResponseService $responseService,
        RegisterRequest $registerRequest
    ): JsonResponse
    {
        $response = $authService->register($registerRequest);

        if (count($response) > 0) {
            return $responseService->success([AuthApiResource::make($response)]);
        } else {
            return $responseService->unprocessableContent(['message' => __('auth.register.failed')]);
        }
    }

    public function refreshToken(
        AuthService $authService,
        ResponseService $responseService,
        HttpRequest $request
    ): JsonResponse
    {
        $response = $authService->refreshToken($request);

        return $responseService->success([AuthApiResource::make($response)]);
    }
}
