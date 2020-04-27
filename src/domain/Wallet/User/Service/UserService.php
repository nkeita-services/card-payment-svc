<?php


namespace Payment\Wallet\User\Service;


use Payment\Wallet\User\Entity\UserEntityInterface;
use Payment\Wallet\User\Repository\Exception\UserNotFoundRepositoryException;
use Payment\Wallet\User\Repository\UserRepositoryInterface;
use Payment\Wallet\User\Service\Exception\UserNotFoundServiceException;

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
        try {
            return $this->userRepository->fetchWithUserId(
                $userId
            );
        } catch (UserNotFoundRepositoryException $e) {
            throw new UserNotFoundServiceException(
                $e->getMessage()
            );
        }
    }
}
