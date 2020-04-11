<?php


namespace App\Providers\Infrastructure\Api\Auth\OAuth2\MTN;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Auth\OAuth2\Client as OAuth2Client;

class CollectionOauthClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('CollectionOauthClient', function ($app) {

            return new OAuth2Client(
                '8ad7c789-0c28-48a3-be48-3dbca347d7e7',
                '47d831c2af484fd8bc084e03195a5aff',
                'https://sandbox.momodeveloper.mtn.com/collection/token/'
            );
        });
    }
}
