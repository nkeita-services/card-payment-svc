<?php


namespace App\Providers\Infrastructure\CloudRun\Metadata;


use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;

class CloudRunMetadataGuzzleClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('CloudRunMetadataGuzzleClient', function ($app) {

            return new Client([
                'base_uri' => 'http://metadata.google.internal',
                'headers' => [
                    'Metadata-Flavor' => 'Google'
                ]
            ]);
        });
    }
}
