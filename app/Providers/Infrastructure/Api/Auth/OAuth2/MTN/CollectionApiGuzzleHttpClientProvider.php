<?php


namespace App\Providers\Infrastructure\Api\Auth\OAuth2\MTN;


use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Auth\OAuth2\Client as OAuth2Client;
use League\OAuth2\Client\Token\AccessToken;

class CollectionApiGuzzleHttpClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('CollectionApiGuzzleHttpClient', function ($app) {

            /**
             * @var $oauth2Client AccessToken
             */
            $oauth2Client = $app->make('CollectionOauthClient');

            $headers = [
                'Authorization' => 'Bearer ' . $oauth2Client->getToken(),
                'Accept' => 'application/json',
                //'X-Reference-Id'=> '70316346-81f5-478c-bf26-a5cbe4ab26dd',
                'X-Target-Environment'=>'sandbox',
                'Ocp-Apim-Subscription-Key'=> 'a1b2dd2992b941279ff726ccfc4c842a',
                'Content-Type'=>'application/json'
            ];
            return new Client([
                'base_uri' => 'https://sandbox.momodeveloper.mtn.com',
                'headers'=> $headers
            ]);
        });
    }
}
