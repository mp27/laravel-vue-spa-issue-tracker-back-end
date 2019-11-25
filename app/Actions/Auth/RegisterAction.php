<?php


namespace App\Actions\Auth;


use App\User;
use Illuminate\Support\Facades\Hash;

class RegisterAction
{
    public function run($request)
    {
        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password'])
        ]);
    }
}
