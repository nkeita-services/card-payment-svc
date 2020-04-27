<?php


namespace Payment\Wallet\User\Repository;


use Infrastructure\Api\Rest\Client\WalletGateway\User\UserApiClientInterface;
use Payment\Wallet\User\Entity\UserEntityInterface;
use Payment\Wallet\User\Repository\Exception\UserNotFoundRepositoryException;

interface UserRepositoryInterface
{

    /**
     * @param string $userId
     * @return UserEntityInterface
     * @throws UserNotFoundRepositoryException
     */
    public function fetchWithUserId(
        string $userId
    ): UserEntityInterface;
}
