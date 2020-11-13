<?php


namespace App\Providers\Domain\Paypal\PaymentExecution\Service;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Secrets\SecretManagerInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;
use Payment\Paypal\PaymentExecution\Service\PaymentExecutionService;
use Payment\Paypal\PaymentExecution\Service\PaymentExecutionServiceInterface;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;


class PaymentExecutionServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PaymentExecutionServiceInterface::class, function ($app) {
            $environment = new SandboxEnvironment(
                $app->make(SecretManagerInterface::class)->get('PAYPAL_CLIENT_ID'),
                $app->make(SecretManagerInterface::class)->get('PAYPAL_CLIENT_SECRET')
            );

            return new PaymentExecutionService(
                $app->make(CashInTransactionServiceInterface::class),
                new PayPalHttpClient($environment),
                $app->make(OrdersCreateRequest::class)
            );
        });
    }
}

