<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Contracts\AuthContract as AuthService;
use App\Services\Contracts\ResponseContract as ResponseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(
        ResponseService $responseService,
        Request $request
    ): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('AccessToken')->accessToken;

            return $responseService->success($success);
        } else {
            return $responseService->unprocessableContent(['message' => __('auth.login_failed')]);
        }
    }

    public function logOutUser(
        ResponseService $responseService,
    ): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return $responseService->success(['message' => 'Logged out']);
    }

    public function resetPassword(
        AuthService $authService,
        ResponseService $responseService,
        Request $request
    ): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'exists:users,email', 'max:50'],
            'verify_code' => ['required', 'digits:6'],
            'password' => ['required_with:confirmPassword', 'string', 'same:confirmPassword', 'min:8', 'max:24'],
            'confirmPassword' => ['required', 'string', 'min:8', 'max:24']
        ]);

        $response = $authService->resetPassword($request);

        if (!$response['status']) {
            return $responseService->forbidden($response['body']);
        }

        return $responseService->success($response['body']);
    }

    public function register(
        AuthService $authService,
        ResponseService $responseService,
        Request $request
    ): JsonResponse
    {
        $response = $authService->register($request);

        return $responseService->success($response);
    }
}
