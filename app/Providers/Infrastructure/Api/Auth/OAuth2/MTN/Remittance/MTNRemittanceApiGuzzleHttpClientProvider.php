<?php


namespace App\Providers\Infrastructure\Api\Auth\OAuth2\MTN\Remittance;


use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Secrets\SecretManagerInterface;
use League\OAuth2\Client\Token\AccessToken;

class MTNRemittanceApiGuzzleHttpClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('MTNRemittanceApiGuzzleHttpClient', function ($app) {

            /**
             * @var $oauth2Client AccessToken
             */
            $oauth2Client = $app->make('MTNRemittanceOauthClient');

            $headers = [
                'Authorization' => 'Bearer ' . $oauth2Client->getToken(),
                'Accept' => 'application/json',
                'X-Target-Environment'=>$app->make(SecretManagerInterface::class)->get('MTN_TARGET_ENVIRONMENT'),
                'Ocp-Apim-Subscription-Key'=> $app->make(SecretManagerInterface::class)->get('MTN_REMITTANCE_OCP_APIM_SUBSCRIPTION_KEY'),
                'Content-Type'=>'application/json'
            ];
            return new Client([
                'base_uri' => $app->make(SecretManagerInterface::class)->get('MTN_MOMO_API_URI'),
                'headers'=> $headers
            ]);
        });
    }
}
