<?php


namespace Payment\Wallet\User\Service;


use Payment\Wallet\User\Entity\UserEntityInterface;
use Payment\Wallet\User\Service\Exception\UserNotFoundServiceException;

interface UserServiceInterface
{

    /**
     * @param string $userId
     * @return UserEntityInterface
     * @throws UserNotFoundServiceException
     */
    public function fetchFromUserId(
        string $userId
    ): UserEntityInterface;
}
