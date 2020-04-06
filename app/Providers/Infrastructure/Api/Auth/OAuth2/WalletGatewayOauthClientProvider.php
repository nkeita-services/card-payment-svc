<?php


namespace App\Providers\Infrastructure\Api\Auth\OAuth2;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Auth\OAuth2\Client as OAuth2Client;

class WalletGatewayOauthClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('WalletGatewayOauthClient', function ($app) {

            return new OAuth2Client(
                '1t37i9t15h3rvlib7g1u7odp23',
                'avqbjl9vfeo1spfhv5qfp4ojrplg6guf3gv44q1hpvffk6nab8g',
                'https://nbk-wallet.auth.eu-west-1.amazoncognito.com/oauth2/token'
            );
        });
    }
}
