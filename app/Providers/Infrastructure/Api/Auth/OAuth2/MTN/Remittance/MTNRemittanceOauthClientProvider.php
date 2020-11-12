<?php


namespace App\Providers\Infrastructure\Api\Auth\OAuth2\MTN\Remittance;


use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Secrets\SecretManagerInterface;
use League\OAuth2\Client\Token\AccessToken;

class MTNRemittanceOauthClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('MTNRemittanceOauthClient', function ($app) {
            $httpClient = new Client([
                'base_uri' => $app->make(SecretManagerInterface::class)->get('MTN_MOMO_API_URI'),
                'headers' => [
                    'Ocp-Apim-Subscription-Key' => $app->make(SecretManagerInterface::class)->get('MTN_REMITTANCE_OCP_APIM_SUBSCRIPTION_KEY'),
                ],
                'auth' => [
                    $app->make(SecretManagerInterface::class)->get('MTN_REMITTANCE_BASIC_AUTH_USERNAME'),
                    $app->make(SecretManagerInterface::class)->get('MTN_REMITTANCE_BASIC_AUTH_PASSWORD')
                ]
            ]);

            $response = $httpClient->post('/remittance/token/');

            return new AccessToken(
                json_decode(
                    $response->getBody()->getContents(),
                    true
                )
            );
        });
    }
}
