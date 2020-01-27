<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user =  Socialite::driver($provider)->stateless()->user();
        dd($user);
    }
}
