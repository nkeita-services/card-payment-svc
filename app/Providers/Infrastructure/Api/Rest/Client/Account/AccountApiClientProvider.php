<?php


namespace App\Providers\Infrastructure\Api\Rest\Client\Account;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\Account\AccountApiClientInterface;
use Infrastructure\Api\Rest\Client\Account\AccountApiGuzzleHttpClient;
use Infrastructure\Api\Rest\Client\Account\Mapper\AccountBalanceOperationResultMapper;
use Infrastructure\Api\Rest\Client\Account\Mapper\AccountMapper;

class AccountApiClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AccountApiClientInterface::class, function ($app) {
            return new AccountApiGuzzleHttpClient(
                $app->make('WalletGatewayGuzzleHttpClient'),
                new AccountMapper(),
                new AccountBalanceOperationResultMapper()
            );
        });
    }
}
