<?php


namespace App\Providers\Infrastructure\CloudRun\Metadata\OAuth\IDToken;


use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Infrastructure\CloudRun\Metadata\OAuth\IDToken\OAuthIDTokenService;
use Infrastructure\CloudRun\Metadata\OAuth\IDToken\OAuthIDTokenServiceInterface;

class OAuthIDTokenServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(OAuthIDTokenServiceInterface::class, function ($app) {

            return new OAuthIDTokenService(
                $app->make('CloudRunMetadataGuzzleClient'),
                env('GCLOUD_DEFAULT_OAUTH_ID_TOKEN', getenv('GCLOUD_DEFAULT_OAUTH_ID_TOKEN'))
            );
        });
    }
}
