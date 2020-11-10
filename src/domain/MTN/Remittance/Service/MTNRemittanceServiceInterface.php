<?php


namespace Payment\MTN\Remittance\Service;


use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;

interface MTNRemittanceServiceInterface
{

    /**
     * @param CashOutTransactionEntityInterface $entity
     * @return CashOutTransactionEntityInterface
     */
    public function transferFromCashOutRequest(
        CashOutTransactionEntityInterface $entity
    ): CashOutTransactionEntityInterface;
}
