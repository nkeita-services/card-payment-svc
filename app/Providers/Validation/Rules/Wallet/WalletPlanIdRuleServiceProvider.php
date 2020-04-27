<?php


namespace App\Providers\Validation\Rules\Wallet;


use App\Rules\Wallet\WalletPlanIdRule;
use Illuminate\Support\ServiceProvider;
use Wallet\Wallet\Plan\Service\WalletPlanServiceInterface;

class WalletPlanIdRuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WalletPlanIdRule::class, function ($app) {
            return new WalletPlanIdRule(
                $app->make(WalletPlanServiceInterface::class)
            );
        });
    }
}
