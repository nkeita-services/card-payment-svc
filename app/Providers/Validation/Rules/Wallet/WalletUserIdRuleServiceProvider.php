<?php


namespace App\Providers\Validation\Rules\Wallet;
use App\Rules\Wallet\WalletUserIdRule;
use Illuminate\Support\ServiceProvider;
use Wallet\Wallet\User\Service\UserServiceInterface;

class WalletUserIdRuleServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(WalletUserIdRule::class, function ($app) {
            return new WalletUserIdRule(
                $app->make(UserServiceInterface::class)
            );
        });
    }
}
