<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\VerifiedCodeRequest;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function register(RegisterRequest $request)
    {

        $data = User::create(['password' => Hash::make($request->password), 'verification_code' => mt_rand(100000, 999999)] + $request->validated());
        $data['token'] = $data->createToken($data)->plainTextToken;
        return $this->sendResponse('user registerd successfully', $data);
    }

    public function login(LoginRequest $request)
    {

        if (Auth::attempt(['phone' => $request->phone, 'password' => $request->password])) {
            $user = Auth::user();
            $user['token'] = $user->createToken($user)->plainTextToken;
            return $this->sendResponse('login successfully', $user);
        }
        return $this->sendError('Credentials are not correct');
    }

    public function isVerified(VerifiedCodeRequest $request)
    {
        $user = Auth::user();
        // return $user ;
        if ($user->verification_code !== $request->verification_code)
            return $this->sendError('Verification code is not correct');
        $user->update(['is_verified' => 1]);
        return $this->sendResponse('Verification Code is correct');
    }

    public function logout(Request $request)
    {
        Auth::user()->tokens()->delete();
        return $this->sendResponse('logout successfully');
    }
}
