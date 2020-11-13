<?php


namespace App\Providers\Domain\Paypal\PaymentExecution\Repository;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Secrets\SecretManagerInterface;
use MongoDB\Client;
use Payment\Paypal\PaymentExecution\Repository\PaymentExecutionRepository;
use Payment\Paypal\PaymentExecution\Repository\PaymentExecutionRepositoryInterface;


class PaymentExecutionRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PaymentExecutionRepositoryInterface::class, function ($app) {

            $mongoClient = new Client(
                $app->make(SecretManagerInterface::class)->get('DB_MONGODB_URI')
            );
            $collection = $mongoClient->selectCollection('wallet', 'payments');
            return new PaymentExecutionRepository(
                $collection
            );
        });
    }
}
