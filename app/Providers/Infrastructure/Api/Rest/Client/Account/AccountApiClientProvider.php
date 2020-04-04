<?php


namespace App\Providers\Infrastructure\Api\Rest\Client\Account;

use Illuminate\Support\ServiceProvider;
use Infrastructure\Api\Rest\Client\Account\AccountApiClientInterface;
use GuzzleHttp\Client;
use Infrastructure\Api\Rest\Client\Account\AccountApiGuzzleHttpClient;
use Infrastructure\Api\Rest\Client\Account\Mapper\AccountMapper;
use League\OAuth2\Client\Provider\GenericProvider;

class AccountApiClientProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AccountApiClientInterface::class, function ($app) {
            $provider = new GenericProvider(
                    [
                        'clientId'                => '1t37i9t15h3rvlib7g1u7odp23',    
                        'clientSecret'            => 'avqbjl9vfeo1spfhv5qfp4ojrplg6guf3gv44q1hpvffk6nab8g',  
                        'urlAccessToken'          => 'https://nbk-wallet.auth.eu-west-1.amazoncognito.com/oauth2/token',
                        'urlAuthorize'=>'',
                        'urlResourceOwnerDetails'=>''
                    ]);
            $accessToken = $provider->getAccessToken('client_credentials');
            
            $headers = [
                           'Authorization' => 'Bearer ' . $accessToken->getToken(),        
                           'Accept'        => 'application/json',
            ];
            
            
            return new AccountApiGuzzleHttpClient(
                new Client([
                    'base_uri' => 'https://wallet-account-svc-py-fjhmnd5asa-ew.a.run.app',
                    $headers
                ]),
                new AccountMapper()
            );
        });
    }
}
