<?php


namespace Payment\Wallet\User\Repository;


use Infrastructure\Api\Rest\Client\WalletGateway\User\UserApiClientInterface;
use Payment\Wallet\User\Entity\UserEntityInterface;
use Infrastructure\Api\Rest\Client\WalletGateway\User\Exception\UserNotFoundException as ApiClientUserNotFoundException;
use Payment\Wallet\User\Repository\Exception\UserNotFoundRepositoryException;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @var UserApiClientInterface
     */
    private $userApiClient;

    /**
     * UserRepository constructor.
     * @param UserApiClientInterface $userApiClient
     */
    public function __construct(
        UserApiClientInterface $userApiClient
    ){
        $this->userApiClient = $userApiClient;
    }


    /**
     * @inheritDoc
     */
    public function fetchWithUserId(
        string $userId
    ): UserEntityInterface{
        try {
            return $this
                ->userApiClient
                ->fetch(
                    $userId
                );
        } catch (ApiClientUserNotFoundException $e) {
            throw new UserNotFoundRepositoryException(
                $e->getMessage()
            );
        }
    }
}
