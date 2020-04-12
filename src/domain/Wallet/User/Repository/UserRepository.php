<?php


namespace Payment\Wallet\User\Repository;


use Infrastructure\Api\Rest\Client\WalletGateway\User\UserApiClientInterface;
use Payment\Wallet\User\Entity\UserEntityInterface;

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
        return $this
            ->userApiClient
            ->fetch(
                $userId
            );
    }
}
