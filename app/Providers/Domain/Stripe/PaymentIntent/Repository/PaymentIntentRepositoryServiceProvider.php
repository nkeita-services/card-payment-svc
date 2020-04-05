<?php


namespace App\Providers\Domain\Stripe\PaymentIntent\Repository;


use Illuminate\Support\ServiceProvider;
use MongoDB\Client;
use Payment\Stripe\PaymentIntent\Repository\PaymentIntentRepository;
use Payment\Stripe\PaymentIntent\Repository\PaymentIntentRepositoryInterface;

class PaymentIntentRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PaymentIntentRepositoryInterface::class, function ($app) {

            $mongoClient = new Client('mongodb+srv://wallet-account-user:ccKUENpgY2Bj0gly@cluster0-ydv8p.mongodb.net/wallet?authSource=admin');
            $collection = $mongoClient->selectCollection('wallet', 'payments');
            return new PaymentIntentRepository(
                $collection
            );
        });
    }
}
