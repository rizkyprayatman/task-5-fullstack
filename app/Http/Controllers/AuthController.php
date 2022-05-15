<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Validator;
use Auth;
use Hash;

use App\Models\User;

class AuthController extends BaseController
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return $this->responseError('Login failed', 422, $validator->errors());
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            
            $response = [
                'token' => $user->createToken('MyToken')->accessToken,
                'name' => $user->name,
                'id' => $user->id
            ];

            return $this->responseOk($response);
        } else {
            return $this->responseError('Wrong email or password', 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return $this->responseError('Registration failed', 422, $validator->errors());
        }

        $params = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ];

        if ($user = User::create($params)) {
            $token = $user->createToken('MyToken')->accessToken;

            $response = [
                'token' => $token,
                'user' => $user,
            ];

            return $this->responseOk($response);
        } else {
            return $this->responseError('Registration failed', 400);
        }
    }

    public function profile(Request $request)
    {
        return $this->responseOk($request->user());
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $request->user()->tokens->each(function ($token, $key) {
                 $token->delete();
             });
          }
        return response()->json("Logged out successfully.", 200);
    }

    public function users() {
        $users = User::all();
        return response()->json($users);
    }
}
