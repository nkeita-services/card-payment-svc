<?php


namespace App\Providers\Validation\Rules\CashIn;


use App\Rules\CashIn\CashInOriginatorRule;
use Illuminate\Support\ServiceProvider;
use Payment\Wallet\User\Service\UserServiceInterface;
use Laravel\Lumen\Application;

class CashInOriginatorRuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CashInOriginatorRule::class, function (Application $app) {
            return new CashInOriginatorRule(
                $app->make(UserServiceInterface::class)
            );
        });
    }
}
