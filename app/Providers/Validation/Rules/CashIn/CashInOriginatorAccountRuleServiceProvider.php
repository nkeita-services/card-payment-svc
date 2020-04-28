<?php


namespace App\Providers\Validation\Rules\CashIn;


use App\Rules\CashIn\CashInOriginatorAccountRule;
use Illuminate\Support\ServiceProvider;
use Payment\Account\Service\AccountServiceInterface;

class CashInOriginatorAccountRuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CashInOriginatorAccountRule::class, function ($app) {
            return new CashInOriginatorAccountRule(
                $app->make(AccountServiceInterface::class)
            );
        });
    }
}
