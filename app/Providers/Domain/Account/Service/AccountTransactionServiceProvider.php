<?php


namespace App\Providers\Domain\Wallet\Account\Service;


use Illuminate\Support\ServiceProvider;
use Wallet\Wallet\Account\Service\AccountTransactionService;
use Wallet\Wallet\Account\Service\AccountTransactionServiceInterface;
use Wallet\Wallet\Event\Service\EventServiceInterface;

class AccountTransactionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AccountTransactionServiceInterface::class, function ($app) {
            return new AccountTransactionService(
                $app->make(EventServiceInterface::class)
            );
        });
    }
}
