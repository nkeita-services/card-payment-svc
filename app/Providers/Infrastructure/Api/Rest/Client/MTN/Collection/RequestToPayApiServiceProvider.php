<?php


namespace App\Providers\Infrastructure\Api\Rest\Client\MTN\Collection;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\MTN\Collection\Mapper\RequestToPayMapper;
use Infrastructure\Api\Rest\Client\MTN\Collection\RequestToPayApiClientInterface;
use Infrastructure\Api\Rest\Client\MTN\Collection\RequestToPayApiGuzzleHttpClient;

class RequestToPayApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RequestToPayApiClientInterface::class, function ($app) {
            return new RequestToPayApiGuzzleHttpClient(
                $app->make('CollectionApiGuzzleHttpClient'),
                new RequestToPayMapper()
            );
        });
    }
}
