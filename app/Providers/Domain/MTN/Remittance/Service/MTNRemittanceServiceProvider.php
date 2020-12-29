<?php


namespace App\Providers\Domain\MTN\Remittance\Service;


use Illuminate\Support\ServiceProvider;
use Payment\CashOut\Transaction\Service\CashOutTransactionServiceInterface;
use Payment\MTN\Remittance\Repository\RemittanceRepositoryInterface;
use Payment\MTN\Remittance\Service\MTNRemittanceService;
use Payment\MTN\Remittance\Service\MTNRemittanceServiceInterface;
use Payment\Wallet\Fee\Quote\Service\QuoteFeeServiceInterface;
use Payment\Wallet\WalletGateway\WalletGatewayServiceInterface;

class MTNRemittanceServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MTNRemittanceServiceInterface::class, function ($app) {

            return new MTNRemittanceService(
                $app->make(RemittanceRepositoryInterface::class),
                $app->make(CashOutTransactionServiceInterface::class),
                $app->make(WalletGatewayServiceInterface::class),
                $app->make(QuoteFeeServiceInterface::class)
            );
        });
    }
}
