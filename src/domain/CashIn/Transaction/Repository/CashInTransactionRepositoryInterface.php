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

    /**
     * @param string $transactionId
     * @param array $extras
     * @return bool
     */
    public function addExtras(
        string $transactionId,
        array $extras
    ):bool;
}
