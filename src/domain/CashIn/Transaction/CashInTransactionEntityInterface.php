<?php


namespace Payment\CashIn\Transaction;


interface CashInTransactionEntityInterface
{
    const TYPE_MTN = 'MTN';

    const STATUS_PENDING = 'pending';
    const STATUS_ERROR = 'error';
    const STATUS_SUCCESSFUL = 'successful';

    const DESCRIPTION_DEFAULT = 'request to pay';
    /**
     * @return float
     */
    public function getAmount(): float;

    /**
     * @return string
     */
    public function getCurrency(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getAccountId(): string;

    /**
     * @return array
     */
    public function getOriginator(): array;

    /**
     * @return string
     */
    public function getTransactionId(): string;

    /**
     * @param string $transactionId
     * @return CashInTransactionEntity
     */
    public function setTransactionId(string $transactionId): CashInTransactionEntity;

    /**
     * @return string
     */
    public function getStatus(): string;

    /**
     * @return int
     */
    public function getTimestamp(): int;

    /**
     * @return array
     */
    public function getExtras(): ?array;

    /**
     * @return string
     */
    public function getType(): string;

}
