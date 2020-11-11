<?php


namespace Payment\Account\Repository;


use Infrastructure\Api\Rest\Client\Account\AccountApiClientInterface;
use Payment\Account\Entity\AccountEntityInterface;
use Payment\Account\Collection\AccountCollectionInterface;

class AccountRepository implements AccountRepositoryInterface
{

    /**
     * @var AccountApiClientInterface
     */
    private $accountApiClient;

    public function __construct(AccountApiClientInterface $accountApiClient)
    {
        $this->accountApiClient = $accountApiClient;
    }
    /**
     * @inheritDoc
     */
    public function fetchWithUserIdAndAccountId(
        string $userId,
        string $accountId
    ): AccountEntityInterface{
        return $this
            ->accountApiClient
            ->fetchWithUserIdAndAccountId(
                $userId,
                $accountId
            );
    }


    /**
     * @inheritDoc
     */
    public function topUpWithUserIdAndAccountId(
        string $userId,
        string $accountId,
        float $amount,
        string $description
    ): AccountEntityInterface
    {
        return $this
            ->accountApiClient
            ->topUpWithUserIdAndAccountId(
                $userId,
                $accountId,
                $amount,
                $description
            );
    }

    /**
     * @inheritDoc
     */
    public function debitWithUserIdAndAccountId(
        string $userId,
        string $accountId,
        float $amount,
        string $description
    ): AccountEntityInterface{
        return $this
            ->accountApiClient
            ->debitWithUserIdAndAccountId(
                $userId,
                $accountId,
                $amount,
                $description
            );
    }
}
