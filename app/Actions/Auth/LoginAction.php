<?php


namespace App\Actions\Auth;


use Illuminate\Http\Request;
use Laravel\Passport\Client;

class LoginAction
{
    public function run($request)
    {
        $passwordGrantClient = Client::where('password_client', 1)->first();

        $data = [
            'grant_type' => 'password',
            'client_id' => $passwordGrantClient->id,
            'client_secret' => $passwordGrantClient->secret,
            'username' => $request['email'],
            'password' => $request['password'],
            'scope' => '*'
        ];

        $tokenRequest = Request::create('/oauth/token', 'post', $data);

        $tokenResponse = app()->handle($tokenRequest);
        $contentString = $tokenResponse->content();

        return [
            "response" => $tokenResponse,
            "content" => json_decode($contentString, true)
        ];
    }
}
