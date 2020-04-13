<?php


namespace App\Providers\Domain\CashIn\Transaction\Repository;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Storage\Database\MongoDB\MongoClientInterface;
use Payment\CashIn\Transaction\Repository\CashInTransactionRepository;
use Payment\CashIn\Transaction\Repository\CashInTransactionRepositoryInterface;

class CashInTransactionRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CashInTransactionRepositoryInterface::class, function ($app) {

            $mongoClient = $app->make(MongoClientInterface::class);
            $collection = $mongoClient->selectCollection('wallet', 'paymentsCashInTransactions');
            return new CashInTransactionRepository(
                $collection
            );
        });
    }
}
