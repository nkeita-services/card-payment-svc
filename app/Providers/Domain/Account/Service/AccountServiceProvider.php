<?php


namespace App\Providers\Domain\Account\Service;

use Illuminate\Support\ServiceProvider;
use Payment\Account\Service\AccountService;
use Payment\Account\Service\AccountServiceInterface;
use Payment\Account\Repository\AccountRepositoryInterface;

class AccountServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AccountServiceInterface::class, function ($app) {
            return new AccountService(
                $app->make(AccountRepositoryInterface::class)
            );
        });
    }
}

