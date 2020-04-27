<?php


namespace App\Providers\Domain\Stripe\PaymentIntent\Service;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Secrets\SecretManagerInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;
use Payment\Stripe\PaymentIntent\Repository\PaymentIntentRepositoryInterface;
use Payment\Stripe\PaymentIntent\Service\PaymentIntentService;
use Payment\Stripe\PaymentIntent\Service\PaymentIntentServiceInterface;
use Stripe\Stripe;

class PaymentIntentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PaymentIntentServiceInterface::class, function ($app) {
            Stripe::setApiKey(
                $app->make(SecretManagerInterface::class)->get('STRIPE_SK_KEY')
            );
            return new PaymentIntentService(
                $app->make(SecretManagerInterface::class)->get('STRIPE_PK_KEY'),
                $app->make(CashInTransactionServiceInterface::class)
            );
        });
    }
}
