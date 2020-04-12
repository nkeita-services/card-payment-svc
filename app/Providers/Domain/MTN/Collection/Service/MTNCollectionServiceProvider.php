<?php


namespace App\Providers\Domain\MTN\Collection\Service;


use Illuminate\Support\ServiceProvider;
use Payment\Account\Service\AccountServiceInterface;
use Payment\MTN\Collection\Repository\CollectionRepositoryInterface;
use Payment\MTN\Collection\Service\CollectionService;
use Payment\MTN\Collection\Service\CollectionServiceInterface;

class MTNCollectionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CollectionServiceInterface::class, function ($app) {

            return new CollectionService(
                $app->make(CollectionRepositoryInterface::class),
                $app->make(AccountServiceInterface::class)
            );
        });
    }
}
