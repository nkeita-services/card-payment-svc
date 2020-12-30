<?php


namespace App\Providers\Domain\Wallet\Fee\Quote\Service\Mapper;


use Illuminate\Support\ServiceProvider;
use Payment\Account\Service\AccountServiceInterface;
use Payment\Wallet\Fee\Quote\Service\Mapper\QuoteMapper;
use Payment\Wallet\Fee\Quote\Service\Mapper\QuoteMapperInterface;

class QuoteMapperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(QuoteMapperInterface::class, function ($app) {;
            return new QuoteMapper(
                $app->make(AccountServiceInterface::class),
            );
        });
    }
}
