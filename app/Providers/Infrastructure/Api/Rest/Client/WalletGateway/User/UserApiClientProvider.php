<?php


namespace App\Providers\Infrastructure\Api\Rest\Client\WalletGateway\User;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\WalletGateway\User\Mapper\UserMapper;
use Infrastructure\Api\Rest\Client\WalletGateway\User\UserApiClientInterface;
use Infrastructure\Api\Rest\Client\WalletGateway\User\UserApiGuzzleHttpClient;

class UserApiClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserApiClientInterface::class, function ($app) {
            return new UserApiGuzzleHttpClient(
                $app->make('WalletGatewayGuzzleHttpClient'),
                new UserMapper()
            );
        });
    }
}
