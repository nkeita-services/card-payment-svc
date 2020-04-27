<?php


namespace App\Providers\Infrastructure\Secrets;


use Google\Cloud\SecretManager\V1\SecretManagerServiceClient;
use Illuminate\Support\ServiceProvider;
use Infrastructure\CloudRun\Metadata\ProjectID\CloudRunProjectIDInterface;
use Infrastructure\Secrets\SecretManager;
use Infrastructure\Secrets\SecretManagerInterface;

class SecretManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SecretManagerInterface::class, function ($app) {
            return new SecretManager(
                $app->make(CloudRunProjectIDInterface::class),
                'wallet-payment-gateway-svc',
                'latest',
                new SecretManagerServiceClient()
            );
        });
    }
}
