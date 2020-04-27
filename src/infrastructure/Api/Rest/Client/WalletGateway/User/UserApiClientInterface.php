<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\User;


use Infrastructure\Api\Rest\Client\WalletGateway\User\Exception\UserNotFoundException;
use Payment\Wallet\User\Entity\UserEntityInterface;

interface UserApiClientInterface
{
    /**
     * @param string $userId
     * @return UserEntityInterface
     * @throws UserNotFoundException
     */
    public function fetch(
        string $userId
    ): UserEntityInterface;
}
