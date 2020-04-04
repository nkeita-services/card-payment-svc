<?php


namespace App\Providers\Domain\Account\Respository;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\Account\AccountApiClientInterface;
use Payment\Account\Repository\AccountRepository;
use Payment\Account\Repository\AccountRepositoryInterface;

class AccountRepositoryProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AccountRepositoryInterface::class, function ($app) {
            return new AccountRepository(
                $app->make(AccountApiClientInterface::class)
            );
        });
    }
}
