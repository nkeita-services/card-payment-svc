<?php


namespace Payment\CashIn\Transaction\Repository;


use Payment\CashIn\Transaction\CashInTransactionEntityInterface;

interface CashInTransactionRepositoryInterface
{

    /**
     * @param CashInTransactionEntityInterface $transactionEntity
     * @return CashInTransactionEntityInterface
     */
    public function store(CashInTransactionEntityInterface $transactionEntity): CashInTransactionEntityInterface;
}
