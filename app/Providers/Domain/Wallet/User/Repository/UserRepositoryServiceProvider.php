<?php


namespace App\Providers\Domain\Wallet\User\Repository;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\WalletGateway\User\UserApiClientInterface;
use Payment\Wallet\User\Repository\UserRepository;
use Payment\Wallet\User\Repository\UserRepositoryInterface;

class UserRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserRepositoryInterface::class, function ($app) {
            return new UserRepository(
                $app->make(UserApiClientInterface::class)
            );
        });
    }
}
