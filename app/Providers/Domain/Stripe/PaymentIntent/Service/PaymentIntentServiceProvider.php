<?php


namespace App\Providers\Domain\Stripe\PaymentIntent\Service;


use Illuminate\Support\ServiceProvider;
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
            Stripe::setApiKey('sk_test_Uz7JHXYgI9Ih0b6oxf9wCyK300e95hcUlt');
            return new PaymentIntentService(
                'pk_test_muG8jSMNY9OyPOQFCN3JtYMx00w4hXalgG',
                $app->make(CashInTransactionServiceInterface::class)
            );
        });
    }
}
