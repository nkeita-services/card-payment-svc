<?php


namespace App\Providers\Domain\AliPayWechatPay\PaymentOrder\Repository;



use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Soap\Client\AliPayWechatPay\PaymentOrderApiClientInterface;
use Payment\AliPayWechatPay\PaymentOrder\Repository\PaymentOrderRepository;
use Payment\AliPayWechatPay\PaymentOrder\Repository\PaymentOrderRepositoryInterface;

class PaymentOrderRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PaymentOrderRepositoryInterface::class, function ($app) {
            return new PaymentOrderRepository(
                $app->make(PaymentOrderApiClientInterface::class)
            );
        });
    }
}
