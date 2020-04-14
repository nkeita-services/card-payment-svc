<?php


namespace Payment\CashIn\Transaction\Service;


use Payment\CashIn\Transaction\CashInTransactionEntityInterface;

interface CashInTransactionServiceInterface
{

    /**
     * @param CashInTransactionEntityInterface $transactionEntity
     * @return CashInTransactionEntityInterface
     */
    public function store(
        CashInTransactionEntityInterface $transactionEntity
    ): CashInTransactionEntityInterface;

    /**
     * @param string $transactionId
     * @param array $additionalInfo
     * @return bool
     */
    public function addAdditionalInfo(
        string $transactionId,
        array $additionalInfo
    ): bool;
}
