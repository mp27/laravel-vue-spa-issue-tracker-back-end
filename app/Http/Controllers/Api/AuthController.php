<?php


namespace App\Http\Controllers\Api;


use App\Actions\Auth\LoginAction;
use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;

class AuthController extends Controller
{
    public function login(UserLoginRequest $request, LoginAction $loginAction)
    {
        $passportRequest = $loginAction->run($request->all());
        $tokenContent = $passportRequest["content"];

        if (!empty($tokenContent['access_token'])) {
            return $passportRequest["response"];
        }

        if (empty($tokenContent)) {
            return response()->json([
                'message' => 'Email is not verified'
            ]);
        }

        return response()->json([
            'message' => 'Unauthenticated'
        ]);
    }

    public function register(UserRegisterRequest $request, RegisterAction $registerAction)
    {
        $user = $registerAction->run($request->all());

        if (!$user) {
            return response()->json(["success" => false, "message" => 'Registration failed'], 500);
        }

        return response()->json(["success" => true, "message" => 'Registration succeeded']);
    }
}
