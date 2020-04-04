<?php


namespace App\Providers\Infrastructure\Api\Rest\Client\Account;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\Account\AccountApiClientInterface;
use GuzzleHttp\Client;
use Infrastructure\Api\Rest\Client\Account\AccountApiGuzzleHttpClient;
use Infrastructure\Api\Rest\Client\Account\Mapper\AccountMapper;

class AccountApiClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AccountApiClientInterface::class, function ($app) {
            return new AccountApiGuzzleHttpClient(
                new Client([
                    'base_uri' => 'https://wallet-account-svc-py-fjhmnd5asa-ew.a.run.app'
                ]),
                new AccountMapper()
            );
        });
    }
}
