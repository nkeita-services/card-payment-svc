<?php


namespace App\Providers\Infrastructure\Api\Rest\Client\WalletGateway\Plan;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\WalletGateway\Plan\Mapper\WalletPlanMapper;
use Infrastructure\Api\Rest\Client\WalletGateway\Plan\WalletPlanApiClientInterface;
use Infrastructure\Api\Rest\Client\WalletGateway\Plan\WalletPlanApiGuzzleHttpClient;

class WalletPlanApiClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WalletPlanApiClientInterface::class, function ($app) {
            return new WalletPlanApiGuzzleHttpClient(
                $app->make('WalletGatewayGuzzleHttpClient'),
                new WalletPlanMapper()
            );
        });
    }
}
