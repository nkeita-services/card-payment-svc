<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\User;


use GuzzleHttp\Client;
use Infrastructure\Api\Rest\Client\WalletGateway\User\Mapper\UserMapperInterface;
use Payment\Wallet\User\Entity\UserEntityInterface;

class UserApiGuzzleHttpClient implements UserApiClientInterface
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var UserMapperInterface
     */
    private $userMapper;

    /**
     * UserApiGuzzleHttpClient constructor.
     * @param Client $guzzleClient
     * @param UserMapperInterface $userMapper
     */
    public function __construct(
        Client $guzzleClient,
        UserMapperInterface $userMapper
    ){
        $this->guzzleClient = $guzzleClient;
        $this->userMapper = $userMapper;
    }


    /**
     * @inheritDoc
     */
    public function fetch(
        string $userId
    ): UserEntityInterface{
        $response = $this->guzzleClient->get(
            sprintf('v1/wallets/users/%s', $userId)
        );

        return $this->userMapper->createUserFromApiResponse(
            $response
        );
    }
}
