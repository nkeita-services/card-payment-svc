<?php


namespace Infrastructure\CloudRun\Metadata\OAuth\IDToken;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;

class OAuthIDTokenService implements OAuthIDTokenServiceInterface
{

    /**
     * @var Client
     */
    private $guzzleClient;

    private $defaultToken;

    /**
     * OAuthIDTokenService constructor.
     * @param Client $guzzleClient
     * @param $defaultToken
     */
    public function __construct(Client $guzzleClient, $defaultToken)
    {
        $this->guzzleClient = $guzzleClient;
        $this->defaultToken = $defaultToken;
    }


    /**
     * @inheritDoc
     */
    public function token(
        string $audience
    ): string{
        try {
            $response = $this->guzzleClient->get(
                sprintf(
                    '/computeMetadata/v1/instance/service-accounts/default/identity?audience=%s',
                    $audience
                )
            );
        } catch (ConnectException $exception) {
            return $this
                ->defaultToken;
        }

        return $response
            ->getBody()
            ->getContents();
    }
}
