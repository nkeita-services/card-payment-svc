<?php


namespace Payment\Account\Service;


use Payment\Account\Entity\AccountBalanceOperationResultInterface;
use Payment\Account\Entity\AccountEntityInterface;
use Payment\Account\Collection\AccountCollectionInterface;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;
use Payment\Stripe\PaymentIntent\Entity\PaymentIntentInterface;

interface AccountServiceInterface
{
    /**
     * @param string $userId
     * @param string $accountId
     * @return AccountEntityInterface
     */
    public function fetchWithUserIdAndAccountId(
        string $userId,
        string $accountId
    ): AccountEntityInterface;


    /**
     * @param CashInTransactionEntityInterface $transactionEntity
     * @return AccountBalanceOperationResultInterface
     */
    public function topUpFromCashInTransaction(
        CashInTransactionEntityInterface $transactionEntity
    ): AccountBalanceOperationResultInterface;

    /**
     * @param CashOutTransactionEntityInterface $transactionEntity
     * @return AccountBalanceOperationResultInterface
     */
    public function debitFromCashOutTransaction(
        CashOutTransactionEntityInterface $transactionEntity
    ): AccountBalanceOperationResultInterface;
}
