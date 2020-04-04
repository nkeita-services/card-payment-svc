<?php


namespace Payment\Account\Entity;


interface TransactionEntityInterface
{
    /**
     * @return string
     */
    public function getUserId(): string;

    /**
     * @return string
     */
    public function getAccountId(): string;

    /**
     * @return string
     */
    public function getAmount(): string;

    /**
     * @return string
     */
    public function getDescription(): string;

    /**
     * @return string
     */
    public function getOriginator(): string;

    /**
     * @return string
     */
    public function getOriginatorId(): string;

}
