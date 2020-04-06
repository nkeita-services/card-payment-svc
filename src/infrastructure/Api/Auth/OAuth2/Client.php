<?php


namespace Infrastructure\Api\Auth\OAuth2;


use League\OAuth2\Client\Provider\GenericProvider;

class Client implements ClientInterface
{
    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $urlAccessToken;

    /**
     * @var string
     */
    private $urlAuthorize;

    /**
     * @var string
     */
    private $urlResourceOwnerDetails;

    /**
     * @var GenericProvider
     */
    private $provider;

    /**
     * Client constructor.
     * @param string $clientId
     * @param string $clientSecret
     * @param string $urlAccessToken
     * @param string $urlAuthorize
     * @param string $urlResourceOwnerDetails
     */
    public function __construct(
        string $clientId,
        string $clientSecret,
        string $urlAccessToken,
        string $urlAuthorize = '',
        string $urlResourceOwnerDetails = ''){
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->urlAccessToken = $urlAccessToken;
        $this->urlAuthorize = $urlAuthorize;
        $this->urlResourceOwnerDetails = $urlResourceOwnerDetails;

        $this->provider = new GenericProvider(
            [
                'clientId' => $this->clientId,
                'clientSecret' => $this->clientSecret,
                'urlAccessToken' => $this->urlAccessToken,
                'urlAuthorize' => $this->urlAuthorize,
                'urlResourceOwnerDetails' => $this->urlResourceOwnerDetails
            ]);
    }


    /**
     * @inheritDoc
     */
    public function accessToken(): string
    {
        return $this->provider->getAccessToken('client_credentials')->getToken();
    }
}
