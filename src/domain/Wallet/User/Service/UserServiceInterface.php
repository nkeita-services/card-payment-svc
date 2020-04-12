<?php


namespace Payment\Wallet\User\Service;


use Payment\Wallet\User\Entity\UserEntityInterface;

interface UserServiceInterface
{

    /**
     * @param string $userId
     * @return UserEntityInterface
     */
    public function fetchFromUserId(
        string $userId
    ): UserEntityInterface;
}
