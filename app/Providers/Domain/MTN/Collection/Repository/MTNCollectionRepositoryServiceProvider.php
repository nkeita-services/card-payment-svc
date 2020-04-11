<?php


namespace App\Providers\Domain\MTN\Collection\Repository;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\MTN\Collection\CollectionApiClientInterface;
use Payment\MTN\Collection\Repository\CollectionRepository;
use Payment\MTN\Collection\Repository\CollectionRepositoryInterface;

class MTNCollectionRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CollectionRepositoryInterface::class, function ($app) {

            return new CollectionRepository(
                $app->make(CollectionApiClientInterface::class)
            );
        });
    }
}
