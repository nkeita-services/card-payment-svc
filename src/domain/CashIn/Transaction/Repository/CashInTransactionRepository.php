<?php


namespace Payment\CashIn\Transaction\Repository;


use Payment\CashIn\Transaction\CashInTransactionEntityInterface;

interface CashInTransactionRepository
{

    /**
     * @param CashInTransactionEntityInterface $transactionEntity
     * @return CashInTransactionEntityInterface
     */
    public function store(CashInTransactionEntityInterface $transactionEntity): CashInTransactionEntityInterface;
}
