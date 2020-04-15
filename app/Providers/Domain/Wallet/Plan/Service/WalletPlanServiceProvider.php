<?php


namespace App\Providers\Domain\Wallet\Plan\Service;


use Illuminate\Support\ServiceProvider;
use Payment\Wallet\Plan\Repository\WalletPlanRepositoryInterface;
use Payment\Wallet\Plan\Service\WalletPlanService;
use Payment\Wallet\Plan\Service\WalletPlanServiceInterface;

class WalletPlanServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WalletPlanServiceInterface::class, function ($app) {
            return new WalletPlanService(
                $app->make(WalletPlanRepositoryInterface::class)
            );
        });
    }
}
