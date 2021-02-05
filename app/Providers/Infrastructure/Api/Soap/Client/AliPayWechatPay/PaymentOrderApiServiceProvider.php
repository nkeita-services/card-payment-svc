<?php


namespace App\Providers\Infrastructure\Api\Soap\Client\AliPayWechatPay;


use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Soap\Client\AliPayWechatPay\PaymentOrderApiClientInterface;
use Infrastructure\Api\Soap\Client\AliPayWechatPay\PaymentOrderApiGuzzleHttpClient;
use Infrastructure\Secrets\SecretManagerInterface;

class PaymentOrderApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(PaymentOrderApiClientInterface::class, function ($app) {
            $feeServiceUri = $app->make(SecretManagerInterface::class)->get('EASY_EURO_GATEWAY_PAY');
            return new PaymentOrderApiGuzzleHttpClient(
                new Client(
                    [
                        'base_uri' => $feeServiceUri
                    ]
                )
                //$app->make(SecretManagerInterface::class)->get('EASY_EURO_KEY')
            );
        });
    }
}
