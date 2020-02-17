<?php


namespace App\Http\Controllers\Api;


use App\Actions\Auth\RegisterAction;
use App\Http\Controllers\Controller;
use App\SocialAccount;
use App\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToProvider($provider)
    {
        $url = Socialite::driver($provider)->stateless()->redirect()->getTargetUrl();

        return response()->json([
            "url" => $url
        ]);
    }

    public function handleProviderCallback($provider, RegisterAction $registerAction)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        if (!$user->token) {
            // return json
            return response()->json([
                "success" => false,
                "message" => "Failed to login"
            ], 401);
        }

        $appUser = User::whereEmail($user->email)->first();

        if (!$appUser) {
            // create user and add the provider
            $appUser = $registerAction->run([
                'name' => $user->name,
                'password' => Str::random(7),
                'email' => $user->email
            ]);

            $socialAccount = SocialAccount::create([
                'provider' => $provider,
                'provider_user_id' => $user->id,
                'user_id' => $appUser->id
            ]);

        } else {
            // means that we have already this user
            $socialAccount = $appUser->socialAccounts()->where('provider', $provider)->first();

            if (!$socialAccount) {
                // create social account
                $socialAccount = SocialAccount::create([
                    'provider' => $provider,
                    'provider_user_id' => $user->id,
                    'user_id' => $appUser->id
                ]);
            }

        }

        // login our user and get the token
        $passportToken = $appUser->createToken('Login token')->accessToken;

        return response()->json([
            'access_token' => $passportToken
        ]);
    }
}
