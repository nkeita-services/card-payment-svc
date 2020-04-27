<?php


namespace App\Providers\Infrastructure\CloudRun\Metadata\ProjectID;


use Illuminate\Support\ServiceProvider;
use Infrastructure\CloudRun\Metadata\ProjectID\CloudRunProjectID;
use Infrastructure\CloudRun\Metadata\ProjectID\CloudRunProjectIDInterface;

class CloudRunProjectIDServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(CloudRunProjectIDInterface::class, function ($app) {

            return new CloudRunProjectID(
                $app->make('CloudRunMetadataGuzzleClient'),
                env('GCLOUD_DEFAULT_PROJECT_ID', getenv('GCLOUD_DEFAULT_PROJECT_ID'))
            );
        });
    }
}
