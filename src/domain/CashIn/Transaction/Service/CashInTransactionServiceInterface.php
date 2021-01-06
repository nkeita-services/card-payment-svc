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
     */
    public function addAdditionalInfo(
        string $transactionId,
        array $additionalInfo
    ): void;

    /**
     * @param string $transactionId
     * @return CashInTransactionEntityInterface
     */
    public function fetchWithTransactionId(
        string $transactionId
    ): CashInTransactionEntityInterface;

    /**
     * @param string $eventType
     * @param string $eventId
     * @return CashInTransactionEntityInterface
     */
    public function fetchWithEventTypeAndEventId(
        string $eventType,
        string $eventId
    ):CashInTransactionEntityInterface;

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

    /**
     * @param string $transactionType
     * @return array
     */
    public function fetchPendingTransactionFor(
        string $transactionType
    ):array;

    /**
     * @param string $transactionId
     * @param array $fees
     * @return CashInTransactionEntityInterface
     */
    public function addTransactionFees(
        string $transactionId,
        array $fees
    ):CashInTransactionEntityInterface;
}
