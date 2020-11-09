<?php


namespace Payment\CashIn\Transaction\Repository;


use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;

interface CashOutTransactionRepositoryInterface
{

    /**
     * @param CashOutTransactionEntityInterface $transactionEntity
     * @return CashOutTransactionEntityInterface
     */
    public function store(
        CashOutTransactionEntityInterface $transactionEntity
    ): CashOutTransactionEntityInterface;

    /**
     * @param string $transactionId
     * @param array $extras
     * @return CashOutTransactionRepositoryInterface
     */
    public function addExtras(
        string $transactionId,
        array $extras
    ):CashOutTransactionRepositoryInterface;

    /**
     * @param string $transactionId
     * @return CashOutTransactionEntityInterface
     */
    public function fetchWithTransactionId(
        string $transactionId
    ): CashOutTransactionEntityInterface;

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
     * @return CashOutTransactionEntityInterface
     */
    public function addTransactionEvent(
        string $transactionId,
        string $eventType,
        array $event
    ):CashOutTransactionEntityInterface;


    /**
     * @param array $criteria
     * @return CashOutTransactionEntityInterface
     */
    public function lookUpExtraInformationFor(
        array $criteria
    ):CashOutTransactionEntityInterface;

    /**
     * @param string $transactionId
     * @param string $status
     * @return CashOutTransactionEntityInterface
     */
    public function updateTransactionStatus(
        string $transactionId,
        string $status
    ): CashOutTransactionEntityInterface;
}
