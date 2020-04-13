<?php


namespace App\Providers\Domain\CashIn\Transaction\Service;


use Illuminate\Support\ServiceProvider;
use Payment\CashIn\Transaction\Repository\CashInTransactionRepositoryInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionService;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;

class CashInTransactionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CashInTransactionServiceInterface::class, function ($app) {
            return new CashInTransactionService(
                $app->make(CashInTransactionRepositoryInterface::class)
            );
        });
    }
}
