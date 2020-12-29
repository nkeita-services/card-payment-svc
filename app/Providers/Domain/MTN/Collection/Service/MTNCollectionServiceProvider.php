<?php


namespace App\Providers\Domain\MTN\Collection\Service;


use Illuminate\Support\ServiceProvider;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;
use Payment\MTN\Collection\Repository\CollectionRepositoryInterface;
use Payment\MTN\Collection\Service\CollectionService;
use Payment\MTN\Collection\Service\CollectionServiceInterface;
use Payment\Wallet\Fee\Quote\Service\QuoteFeeServiceInterface;
use Payment\Wallet\WalletGateway\WalletGatewayServiceInterface;

class MTNCollectionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CollectionServiceInterface::class, function ($app) {

            return new CollectionService(
                $app->make(CollectionRepositoryInterface::class),
                $app->make(CashInTransactionServiceInterface::class),
                $app->make(WalletGatewayServiceInterface::class),
                $app->make(QuoteFeeServiceInterface::class)
            );
        });
    }
}
