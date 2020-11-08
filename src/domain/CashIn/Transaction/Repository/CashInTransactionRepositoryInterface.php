<?php


namespace Payment\CashIn\Transaction\Repository;


use Payment\CashIn\Transaction\CashInTransactionEntityInterface;

interface CashInTransactionRepositoryInterface
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
     * @param array $extras
     * @return CashInTransactionRepositoryInterface
     */
    public function addExtras(
        string $transactionId,
        array $extras
    ):CashInTransactionRepositoryInterface;

    /**
     * @param string $transactionId
     * @return CashInTransactionEntityInterface
     */
    public function fetchWithTransactionId(
        string $transactionId
    ): CashInTransactionEntityInterface;

    /**
     * @param string $transactionType
     * @param string $transactionStatus
     * @return array
     */
    public function fetchAllWithTransactionTypeAndStatus(
        string $transactionType,
        string $transactionStatus
    ):array ;

    /**
     * @param string $transactionId
     * @param string $eventType
     * @param array $event
     * @return CashInTransactionEntityInterface
     */
    public function addTransactionEvent(
        string $transactionId,
        string $eventType,
        array $event
    ):CashInTransactionEntityInterface;


    /**
     * @param array $criteria
     * @return CashInTransactionEntityInterface
     */
    public function lookUpExtraInformationFor(
        array $criteria
    ):CashInTransactionEntityInterface;

    /**
     * @param string $transactionId
     * @param string $status
     * @return CashInTransactionEntityInterface
     */
    public function updateTransactionStatus(
        string $transactionId,
        string $status
    ): CashInTransactionEntityInterface;
}
