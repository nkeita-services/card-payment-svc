<?php


namespace App\Providers\Domain\Wallet\User\Service;


use Illuminate\Support\ServiceProvider;
use Payment\Wallet\User\Repository\UserRepositoryInterface;
use Payment\Wallet\User\Service\UserService;
use Payment\Wallet\User\Service\UserServiceInterface;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(UserServiceInterface::class, function ($app) {
            return new UserService(
                $app->make(UserRepositoryInterface::class)
            );
        });
    }
}
