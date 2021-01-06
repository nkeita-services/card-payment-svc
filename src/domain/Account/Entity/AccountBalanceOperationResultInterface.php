<?php


namespace Payment\Account\Entity;


interface AccountBalanceOperationResultInterface
{
    /**
     * @return AccountEntityInterface
     */
    public function account(): AccountEntityInterface;

    /**
     * @return array
     */
    public function transactionDetails(): array;

    /**
     * @return string
     */
    public function transactionId(): string;
}
