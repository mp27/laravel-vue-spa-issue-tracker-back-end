<?php

namespace App\Http\Controllers\Api;

use App\Actions\User\UpdateUserDetailsAction;
use App\Actions\User\UpdateUserPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeDetailsRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UsersController extends Controller
{
    public function me()
    {
        if (Gate::allows('view-developer-dashboard')) {
            return new UserResource(Auth::user());
        }
    }

    public function changePassword(ChangePasswordRequest $request, UpdateUserPasswordAction $updateUserPasswordAction)
    {
        if ($updateUserPasswordAction->run($request->all(), Auth::id())) {
            return response()->json(["success" => true]);
        }

        return response()->json(["success" => false]);
    }

    public function changeDetails(ChangeDetailsRequest $request, UpdateUserDetailsAction $updateUserDetailsAction)
    {
        if ($updateUserDetailsAction->run($request->all(), Auth::id())) {
            return response()->json(["success" => true]);

        }
        return response()->json(["success" => false]);
    }
}
