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
}
