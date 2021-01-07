<?php


namespace Payment\MTN\Collection\Service;


use Payment\CashIn\Transaction\CashInTransactionEntityInterface;

interface CollectionServiceInterface
{

    /**
     * @param string $accountId
     * @param float $amount
     * @param array $originator
     * @param array $regions
     * @param string|null $message
     * @param string|null $note
     * @return CashInTransactionEntityInterface
     */
    public function requestToPay(
        string $accountId,
        float $amount,
        array $originator,
        array $regions = null,
        string $message = null,
        string $note = null
    ): CashInTransactionEntityInterface;


    /**
     * @param string $transactionId
     * @return CashInTransactionEntityInterface
     */
    public function requestToPayStatus(
        string $transactionId
    ):CashInTransactionEntityInterface;
}
