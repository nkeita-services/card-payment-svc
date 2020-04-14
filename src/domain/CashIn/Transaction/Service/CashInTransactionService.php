<?php


namespace Payment\CashIn\Transaction\Service;


use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashIn\Transaction\Repository\CashInTransactionRepositoryInterface;

class CashInTransactionService implements CashInTransactionServiceInterface
{

    /**
     * @var CashInTransactionRepositoryInterface
     */
    private $cashInTransactionRepository;

    /**
     * CashInTransactionService constructor.
     * @param CashInTransactionRepositoryInterface $cashInTransactionRepository
     */
    public function __construct(
        CashInTransactionRepositoryInterface $cashInTransactionRepository
    ){
        $this->cashInTransactionRepository = $cashInTransactionRepository;
    }


    /**
     * @inheritDoc
     */
    public function store(
        CashInTransactionEntityInterface $transactionEntity
    ): CashInTransactionEntityInterface{
        return $this
            ->cashInTransactionRepository
            ->store(
                $transactionEntity
            );
    }

    /**
     * @inheritDoc
     */
    public function addAdditionalInfo(
        string $transactionId,
        array $additionalInfo
    ): bool{
        return $this
            ->cashInTransactionRepository
            ->addExtras(
                $transactionId,
                $additionalInfo
            );
    }


}
