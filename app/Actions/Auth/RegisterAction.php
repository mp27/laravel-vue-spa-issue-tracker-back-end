<?php


namespace App\Actions\Auth;


use App\Role;
use App\User;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    public function run($request)
    {
        $developerRole = Role::developer()->first();

        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);

        $user->roles()->attach($developerRole->id);

        $user->sendEmailVerificationNotification();

        return $user;
    }
}
