<?php


namespace App\Providers\Domain\Stripe\PaymentIntent\Repository;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Secrets\SecretManagerInterface;
use MongoDB\Client;
use Payment\Stripe\PaymentIntent\Repository\PaymentIntentRepository;
use Payment\Stripe\PaymentIntent\Repository\PaymentIntentRepositoryInterface;

class PaymentIntentRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PaymentIntentRepositoryInterface::class, function ($app) {

            $mongoClient = new Client(
                $app->make(SecretManagerInterface::class)->get('DB_MONGODB_URI')
            );
            $collection = $mongoClient->selectCollection('wallet', 'payments');
            return new PaymentIntentRepository(
                $collection
            );
        });
    }
}
