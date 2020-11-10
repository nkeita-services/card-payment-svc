<?php


namespace App\Providers\Infrastructure\Api\Rest\Client\MTN\Remittance;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\MTN\Remittance\Mapper\TransferMapper;
use Infrastructure\Api\Rest\Client\MTN\Remittance\RemittanceApiClientInterface;
use Infrastructure\Api\Rest\Client\MTN\Remittance\RemittanceApiGuzzleHttpClient;

class RemittanceApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RemittanceApiClientInterface::class, function ($app) {
            return new RemittanceApiGuzzleHttpClient(
                $app->make('CollectionApiGuzzleHttpClient'),
                new TransferMapper()
            );
        });
    }
}
