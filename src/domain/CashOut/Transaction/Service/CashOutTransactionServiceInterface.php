<?php


namespace Payment\CashOut\Transaction\Service;



use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;

interface CashOutTransactionServiceInterface
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
     * @param array $additionalInfo
     */
    public function addAdditionalInfo(
        string $transactionId,
        array $additionalInfo
    ): void;

    /**
     * @param string $transactionId
     * @return CashOutTransactionEntityInterface
     */
    public function fetchWithTransactionId(
        string $transactionId
    ): CashOutTransactionEntityInterface;

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

    /**
     * @param string $transactionType
     * @return array
     */
    public function fetchPendingTransactionFor(
        string $transactionType
    ):array;
}
