<?php


namespace App\Providers\Domain\AliPayWechatPay\PaymentOrder\Service;


use Illuminate\Support\ServiceProvider;
use Payment\AliPayWechatPay\PaymentOrder\Repository\PaymentOrderRepositoryInterface;
use Payment\AliPayWechatPay\PaymentOrder\Service\PaymentOrderService;
use Payment\AliPayWechatPay\PaymentOrder\Service\PaymentOrderServiceInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;
use Payment\Wallet\Fee\Quote\Service\QuoteFeeServiceInterface;

class PaymentOrderServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PaymentOrderServiceInterface::class, function ($app) {
            return new PaymentOrderService(
                $app->make(PaymentOrderRepositoryInterface::class),
                $app->make(CashInTransactionServiceInterface::class),
                $app->make(QuoteFeeServiceInterface::class)
            );
        });
    }
}
