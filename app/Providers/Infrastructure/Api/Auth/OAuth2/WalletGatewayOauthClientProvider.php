<?php


namespace App\Providers\Infrastructure\Api\Auth\OAuth2;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Auth\OAuth2\Client as OAuth2Client;
use Infrastructure\Secrets\SecretManagerInterface;

class WalletGatewayOauthClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('WalletGatewayOauthClient', function ($app) {

            return new OAuth2Client(
                $app->make(SecretManagerInterface::class)->get('WALLET_GATEWAY_OAUTH2_CLIENT_ID'),
                $app->make(SecretManagerInterface::class)->get('WALLET_GATEWAY_OAUTH2_CLIENT_SECRET'),
                $app->make(SecretManagerInterface::class)->get('WALLET_GATEWAY_OAUTH2_ACCESS_TOKEN_URL')
            );
        });
    }
}
