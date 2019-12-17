<?php

namespace App\Http\Controllers\Api;

use App\Actions\User\UpdateUserDetailsAction;
use App\Actions\User\UpdateUserPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function me()
    {
        return new UserResource(Auth::user());
    }

    public function changePassword(Request $request, UpdateUserPasswordAction $updateUserPasswordAction)
    {
        if ($updateUserPasswordAction->run($request->all(), Auth::id())) {
            return response()->json(["success" => true]);
        }

        return response()->json(["success" => false]);
    }

    public function changeDetails(Request $request, UpdateUserDetailsAction $updateUserDetailsAction)
    {
        if ($updateUserDetailsAction->run($request->all(), Auth::id())) {
            return response()->json(["success" => true]);

        }
        return response()->json(["success" => false]);
    }
}
