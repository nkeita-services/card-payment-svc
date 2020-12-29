<?php


namespace App\Providers\Domain\Wallet\Fee\Quote\Service;


use Illuminate\Support\ServiceProvider;
use Payment\Wallet\Fee\Quote\Service\Mapper\QuoteMapperInterface;
use Payment\Wallet\Fee\Quote\Repository\QuoteFeeRepositoryInterface;
use Payment\Wallet\Fee\Quote\Service\QuoteFeeService;
use Payment\Wallet\Fee\Quote\Service\QuoteFeeServiceInterface;

class QuoteFeeServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(QuoteFeeServiceInterface::class, function ($app) {;
            return new QuoteFeeService(
                $app->make(QuoteFeeRepositoryInterface::class),
                $app->make(QuoteMapperInterface::class)
            );
        });
    }
}
