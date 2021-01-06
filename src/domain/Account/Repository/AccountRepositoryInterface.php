<?php


namespace Payment\Account\Repository;


use Payment\Account\Entity\AccountBalanceOperationResultInterface;
use Payment\Account\Entity\AccountEntityInterface;
use Payment\Account\Collection\AccountCollectionInterface;

interface AccountRepositoryInterface
{
    /**
     * @param string $userId
     * @param string $accountId
     * @return AccountEntityInterface
     */
    public function fetchWithUserIdAndAccountId(
        string $userId,
        string $accountId
    ): AccountEntityInterface;

    /**
     * @param string $userId
     * @param string $accountId
     * @param float $amount
     * @param string $description
     * @return AccountBalanceOperationResultInterface
     */
    public function topUpWithUserIdAndAccountId(
        string $userId,
        string $accountId,
        float $amount,
        string $description
    ): AccountBalanceOperationResultInterface;

    /**
     * @param string $userId
     * @param string $accountId
     * @param float $amount
     * @param string $description
     * @return AccountBalanceOperationResultInterface
     */
    public function debitWithUserIdAndAccountId(
        string $userId,
        string $accountId,
        float $amount,
        string $description
    ): AccountBalanceOperationResultInterface;

}
