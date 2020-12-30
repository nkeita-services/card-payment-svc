<?php


namespace App\Providers\Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote\Mapper\QuoteFeeMapper;
use Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote\QuoteFeeApiClientInterface;
use Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote\QuoteFeeApiGuzzleHttpClient;

class QuoteFeeApiClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(QuoteFeeApiClientInterface::class, function ($app) {
            return new QuoteFeeApiGuzzleHttpClient(
                $app->make('WalletGatewayGuzzleHttpClient'),
                new QuoteFeeMapper()
            );
        });
    }
}
