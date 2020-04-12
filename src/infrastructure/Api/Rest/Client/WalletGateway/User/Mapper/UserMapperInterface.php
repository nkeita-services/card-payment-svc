<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\User\Mapper;


use Payment\Wallet\User\Entity\UserEntityInterface;
use Psr\Http\Message\ResponseInterface;

interface UserMapperInterface
{

    /**
     * @param ResponseInterface $response
     * @return UserEntityInterface
     */
    public function createUserFromApiResponse(
        ResponseInterface $response
    ):UserEntityInterface;
}
