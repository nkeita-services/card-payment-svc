<?php


namespace Payment\CashIn\Transaction;


interface CashInTransactionEntityInterface
{
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
}
