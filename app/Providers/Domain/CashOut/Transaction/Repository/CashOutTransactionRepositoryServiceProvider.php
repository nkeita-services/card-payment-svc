<?php


namespace App\Providers\Domain\CashOut\Transaction\Repository;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Storage\Database\MongoDB\MongoClientInterface;
use Payment\CashOut\Transaction\Repository\CashOutTransactionRepository;
use Payment\CashOut\Transaction\Repository\CashOutTransactionRepositoryInterface;

class CashOutTransactionRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CashOutTransactionRepositoryInterface::class, function ($app) {

            $mongoClient = $app->make(MongoClientInterface::class);
            $collection = $mongoClient->selectCollection('wallet', 'paymentsCashOutTransactions');
            return new CashOutTransactionRepository(
                $collection
            );
        });
    }
}
