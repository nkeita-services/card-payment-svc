<?php


namespace App\Providers\Domain\Wallet\Plan\Repository;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\WalletGateway\Plan\WalletPlanApiClientInterface;
use Payment\Wallet\Plan\Repository\WalletPlanRepository;
use Payment\Wallet\Plan\Repository\WalletPlanRepositoryInterface;

class WalletPlanRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WalletPlanRepositoryInterface::class, function ($app) {
            return new WalletPlanRepository(
                $app->make(WalletPlanApiClientInterface::class)
            );
        });
    }
}
