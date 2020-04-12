<?php


namespace Payment\Wallet\User\Service;


use Payment\Wallet\User\Entity\UserEntityInterface;
use Payment\Wallet\User\Repository\UserRepositoryInterface;

class UserService implements UserServiceInterface
{

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * UserService constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    /**
     * @inheritDoc
     */
    public function fetchFromUserId(
        string $userId
    ): UserEntityInterface{
        return $this->userRepository->fetchWithUserId(
            $userId
        );
    }
}
