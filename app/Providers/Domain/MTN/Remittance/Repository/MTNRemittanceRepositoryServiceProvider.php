<?php


namespace App\Providers\Domain\MTN\Collection\Repository;


use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\MTN\Remittance\RemittanceApiClientInterface;
use Payment\MTN\Remittance\Repository\RemittanceRepository;
use Payment\MTN\Remittance\Repository\RemittanceRepositoryInterface;

class MTNRemittanceRepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(RemittanceRepositoryInterface::class, function ($app) {

            return new RemittanceRepository(
                $app->make(RemittanceApiClientInterface::class)
            );
        });
    }
}
