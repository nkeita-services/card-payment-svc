<?php


namespace App\Providers\Infrastructure\Api\Auth\OAuth2;


use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;
use Infrastructure\Api\Auth\OAuth2\Client as OAuth2Client;
use Infrastructure\Secrets\SecretManagerInterface;

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
                'base_uri' => $app->make(SecretManagerInterface::class)->get('WALLET_GATEWAY_URI'),
                'headers' => $headers
            ]);
        });
    }
}
