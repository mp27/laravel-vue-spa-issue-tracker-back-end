<?php


namespace App\Actions\User;


use App\User;

class UpdateUserDetailsAction
{
    public function run($request, $userId)
    {
        $user = User::findOrFail($userId);
        $user->name = $request['name'];
        return $user->save();
    }
}
