<?php


namespace App\Providers\Domain\Wallet;


use Illuminate\Support\ServiceProvider;
use Payment\Account\Service\AccountServiceInterface;
use Payment\Wallet\Plan\Service\WalletPlanServiceInterface;
use Payment\Wallet\User\Service\UserServiceInterface;
use Payment\Wallet\WalletGateway\WalletGatewayService;
use Payment\Wallet\WalletGateway\WalletGatewayServiceInterface;

class WalletGatewayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WalletGatewayServiceInterface::class, function ($app) {

            return new WalletGatewayService(
                $app->make(AccountServiceInterface::class),
                $app->make(UserServiceInterface::class),
                $app->make(WalletPlanServiceInterface::class)
            );
        });
    }
}
