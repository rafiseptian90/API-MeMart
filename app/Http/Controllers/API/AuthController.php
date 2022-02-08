<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Libs\Response\ResponseJSON;
use App\Models\Role;
use App\Traits\AuthAPIDocs;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login']]);
    }

    /**
     * Login Method
     * @param \App\Http\Requests\Auth\LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->only(['username', 'password']);

        if (!Auth::attempt($credentials)) {
            return ResponseJSON::unauthorized('Unauthorized');
        }

        auth()->user()->tokens()->delete();

        if (auth()->user()->role->id === Role::SUPER_ADMIN_ID) {
            $token = auth()->user()->createToken(auth()->user()->username . ' secret token', Role::SUPER_ADMIN_PERMISSIONS)->plainTextToken;
        } else if (auth()->user()->role->id === Role::OPERATOR_ID) {
            $token = auth()->user()->createToken(auth()->user()->username . ' secret token', Role::OPERATOR_PERMISSIONS)->plainTextToken;
        } else {
            $token = auth()->user()->createToken(auth()->user()->username . ' secret token', Role::STUDENT_PERMISSIONS)->plainTextToken;
        }

        return ResponseJSON::successWithData('Login Successful', collect([
            'token' => $token
        ]));
    }

    /**
     * Logout method
     * */
    public function logout(): JsonResponse
    {
        auth()->user()->tokens()->delete();

        return ResponseJSON::success('Logout Successful');
    }

    /**
     * Reset Password method
     * @param
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $requests = $request->only(['old_password', 'new_password', 'new_password_confirmation']);

        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return ResponseJSON::unauthorized('Old password is incorrect');
        }

        auth()->user()->update([
            'password' => bcrypt($request->new_password)
        ]);

        auth()->user()->tokens()->delete();

        return ResponseJSON::success('Your password has been reset, please to re-login');
    }

    /**
     * Get authenticated user
     */
    public function me(): JsonResponse
    {
        return ResponseJSON::successWithData('Profile has been loaded', auth()->user());
    }
}
