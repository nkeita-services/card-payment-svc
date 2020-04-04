<?php


namespace Payment\Account\Service;

use Payment\Account\Entity\AccountEntityInterface;
use Payment\Account\Collection\AccountCollectionInterface;
use Payment\Account\Repository\AccountRepositoryInterface;

class AccountService implements AccountServiceInterface
{
    /**
     * @var AccountRepositoryInterface
     */
    private $accountRepository;

    /**
     * AccountService constructor.
     * @param AccountRepositoryInterface $accountRepository
     */
    public function __construct(
        AccountRepositoryInterface $accountRepository
    )
    {
        $this->accountRepository = $accountRepository;
    }

    /**
     * @inheritDoc
     */
    public function create(
        AccountEntityInterface $accountEntity,
        string $userId,
        array $organizations
    ): AccountEntityInterface
    {
        return $this->accountRepository->create(
            $accountEntity,
            $userId,
            $organizations
        );
    }

    /**
     * @inheritDoc
     */
    public function fetchAllWithUserAndOrganizations(
        string $userId,
        array $organizations
    ): AccountCollectionInterface
    {
        return $this
            ->accountRepository
            ->fetchAllWithUserAndOrganizations(
                $userId,
                $organizations
            );
    }

    /**
     * @inheritDoc
     */
    public function updateWithUserAndAccountAndOrganizations(
        string $userId,
        string $accountId,
        array $organizations,
        array $data
    ): AccountEntityInterface
    {
        return $this
            ->accountRepository
            ->updateWithUserAndAccountAndOrganizations(
                $userId,
                $accountId,
                $organizations,
                $data
            );
    }

    /**
     * @inheritDoc
     */
    public function fetchWithAccountId(string $accountId)
    {
        return $this
            ->accountRepository
            ->fetchWithAccountId($accountId);
    }

    /**
     * @inheritDoc
     */
    public function topUp(
        string $userId,
        string $accountId,
        array $organizations,
        float $amount
    ): AccountEntityInterface
    {
        return $this
            ->accountRepository
            ->topUp(
                $userId,
                $accountId,
                $organizations,
                $amount
            );
    }

    /**
     * @inheritDoc
     */
    public function debit(
        string $userId,
        string $accountId,
        array $organizations,
        float $amount
    ): AccountEntityInterface
    {
        return $this
            ->accountRepository
            ->debit(
                $userId,
                $accountId,
                $organizations,
                $amount
            );
    }


}
