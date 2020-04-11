<?php


namespace App\Providers\Infrastructure\Api\Rest\Client\MTN\Collection;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\MTN\Collection\Mapper\RequestToPayMapper;
use Infrastructure\Api\Rest\Client\MTN\Collection\CollectionApiClientInterface;
use Infrastructure\Api\Rest\Client\MTN\Collection\CollectionApiGuzzleHttpClient;

class CollectionApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CollectionApiClientInterface::class, function ($app) {
            return new CollectionApiGuzzleHttpClient(
                $app->make('CollectionApiGuzzleHttpClient'),
                new RequestToPayMapper()
            );
        });
    }
}
