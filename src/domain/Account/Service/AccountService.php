<?php


namespace Payment\Account\Service;

use Payment\Account\Entity\AccountBalanceOperationResultInterface;
use Payment\Account\Entity\AccountEntityInterface;
use Payment\Account\Collection\AccountCollectionInterface;
use Payment\Account\Repository\AccountRepositoryInterface;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;
use Payment\Stripe\PaymentIntent\Entity\PaymentIntentInterface;

class AccountService implements AccountServiceInterface
{
    /**
     * @var AccountRepositoryInterface
     */
    private $accountRepository;

    /**
     * AccountService constructor.
     * @param AccountRepositoryInterface $accountRepository
     */
    public function __construct(
        AccountRepositoryInterface $accountRepository
    )
    {
        $this->accountRepository = $accountRepository;
    }


    /**
     * @inheritDoc
     */
    public function fetchWithUserIdAndAccountId(
        string $userId,
        string $accountId
    ): AccountEntityInterface{
        return $this
            ->accountRepository
            ->fetchWithUserIdAndAccountId(
                $userId,
                $accountId
            );
    }


    /**
     * @inheritDoc
     */
    public function topUpFromCashInTransaction(
        CashInTransactionEntityInterface $transactionEntity
    ): AccountBalanceOperationResultInterface
    {
        return $this
           ->accountRepository
           ->topUpWithUserIdAndAccountId(
               $transactionEntity->getOriginatorId(),
               $transactionEntity->getAccountId(),
               $transactionEntity->getAmount(),
               $transactionEntity->getDescription()
           );
    }

    /**
     * @inheritDoc
     */
    public function debitFromCashOutTransaction(
        CashOutTransactionEntityInterface $transactionEntity
    ): AccountBalanceOperationResultInterface{
        return $this
            ->accountRepository
            ->debitWithUserIdAndAccountId(
                $transactionEntity->getOriginatorId(),
                $transactionEntity->getAccountId(),
                $transactionEntity->getAmount(),
                $transactionEntity->getDescription()
            );

    }
}
