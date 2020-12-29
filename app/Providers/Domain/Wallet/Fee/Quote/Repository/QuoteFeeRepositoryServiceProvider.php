<?php


namespace App\Providers\Domain\Wallet\Fee\Quote\Repository;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote\QuoteFeeApiClientInterface;
use Payment\Wallet\Fee\Quote\Repository\QuoteFeeRepository;
use Payment\Wallet\Fee\Quote\Repository\QuoteFeeRepositoryInterface;

class QuoteFeeRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(QuoteFeeRepositoryInterface::class, function ($app) {;
            return new QuoteFeeRepository(
                $app->make(QuoteFeeApiClientInterface::class)
            );
        });
    }
}
