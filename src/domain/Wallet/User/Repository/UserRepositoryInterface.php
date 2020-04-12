<?php


namespace Payment\Wallet\User\Repository;


use Infrastructure\Api\Rest\Client\WalletGateway\User\UserApiClientInterface;
use Payment\Wallet\User\Entity\UserEntityInterface;

interface UserRepositoryInterface
{

    /**
     * @param string $userId
     * @return UserEntityInterface
     */
    public function fetchWithUserId(
        string $userId
    ): UserEntityInterface;
}
