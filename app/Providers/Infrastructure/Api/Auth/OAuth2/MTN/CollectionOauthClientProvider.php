<?php


namespace App\Providers\Infrastructure\Api\Auth\OAuth2\MTN;


use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Auth\OAuth2\Client as OAuth2Client;
use League\OAuth2\Client\Token\AccessToken;

class CollectionOauthClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('CollectionOauthClient', function ($app) {
            $httpClient = new Client([
                'base_uri' => 'https://sandbox.momodeveloper.mtn.com',
                'headers' => [
                    'Ocp-Apim-Subscription-Key' => 'a1b2dd2992b941279ff726ccfc4c842a',
                ],
                'auth' => [
                    '8ad7c789-0c28-48a3-be48-3dbca347d7e7',
                    '47d831c2af484fd8bc084e03195a5aff'
                ]
            ]);

            $response = $httpClient->post('/collection/token/');

            return new AccessToken(
                json_decode(
                    $response->getBody()->getContents(),
                    true
                )
            );
        });
    }
}
