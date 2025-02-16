<?php

namespace App\Http\Controllers\API\Auth;

use App\ApiTrait;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller {
    use ApiTrait;
    public function login(LoginRequest $request) {
        try {
            if (!Auth::attempt($request->only(['email', 'password']))) {
                throw new \Exception('The Email or password isn\'t right', 404);
            };
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('client')->plainTextToken;
            return $this->successResponse(['token' => $token], 'User logging in Succsessfully', 201);
        } catch (\Exception  $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }


    public function register(RegisterRequest $request) {
        try {
            $user = User::create([
                'username' => $request->username,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
            ]);
            $token = $user->createToken('client')->plainTextToken;
            return $this->successResponse(['token' => $token], 'User Created Succsessfully', 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), $e->getCode());
        }
    }
}
