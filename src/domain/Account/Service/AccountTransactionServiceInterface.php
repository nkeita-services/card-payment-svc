<?php


namespace Payment\Account\Service;

use DateTimeInterface;
use Payment\Account\Entity\TransactionEntity;
use Payment\Event\Entity\EventEntityInterface;

interface AccountTransactionServiceInterface
{

    /**
     * @param string $accountId
     * @param DateTimeInterface $fromDate
     * @param DateTimeInterface $toDate
     * @return mixed
     */
    public function fetchWithAccountIdAndDateRange(
        string $accountId,
        DateTimeInterface $fromDate,
        DateTimeInterface $toDate
    );

    /**
     * @param TransactionEntity $transactionEntity
     * @return EventEntityInterface
     */
    public function create(
        TransactionEntity $transactionEntity
    ): EventEntityInterface;
}
