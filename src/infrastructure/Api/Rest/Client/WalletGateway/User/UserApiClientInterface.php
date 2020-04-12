<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\User;


use Payment\Wallet\User\Entity\UserEntityInterface;

interface UserApiClientInterface
{
    /**
     * @param string $userId
     * @return UserEntityInterface
     */
    public function fetch(
        string $userId
    ): UserEntityInterface;
}
