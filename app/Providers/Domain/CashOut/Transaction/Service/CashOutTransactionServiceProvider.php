<?php


namespace App\Providers\Domain\CashOut\Transaction\Service;


use Illuminate\Support\ServiceProvider;
use Payment\CashOut\Transaction\Repository\CashOutTransactionRepositoryInterface;
use Payment\CashOut\Transaction\Service\CashOutTransactionService;
use Payment\CashOut\Transaction\Service\CashOutTransactionServiceInterface;

class CashOutTransactionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CashOutTransactionServiceInterface::class, function ($app) {
            return new CashOutTransactionService(
                $app->make(CashOutTransactionRepositoryInterface::class)
            );
        });
    }
}
