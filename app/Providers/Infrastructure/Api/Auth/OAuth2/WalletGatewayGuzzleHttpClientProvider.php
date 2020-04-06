<?php


namespace App\Providers\Infrastructure\Api\Auth\OAuth2;


use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use Infrastructure\Api\Auth\OAuth2\Client as OAuth2Client;

class WalletGatewayGuzzleHttpClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('WalletGatewayGuzzleHttpClient', function ($app) {

            /**
             * @var $oauth2Client OAuth2Client
             */
            $oauth2Client = $app->make('WalletGatewayOauthClient');

            $headers = [
                'Authorization' => 'Bearer ' . $oauth2Client->accessToken(),
                'Accept' => 'application/json',
            ];
            return new Client([
                'base_uri' => 'https://wallet-account-svc-py-fjhmnd5asa-ew.a.run.app',
                $headers
            ]);
        });
    }
}
