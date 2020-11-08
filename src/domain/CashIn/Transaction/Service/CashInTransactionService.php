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
    ): void{
         $this
            ->cashInTransactionRepository
            ->addExtras(
                $transactionId,
                $additionalInfo
            );
    }

    /**
     * @inheritDoc
     */
    public function fetchWithTransactionId(
        string $transactionId
    ): CashInTransactionEntityInterface{
        return $this
            ->cashInTransactionRepository
            ->fetchWithTransactionId(
                $transactionId
            );
    }

    /**
     * @inheritDoc
     */
    public function addTransactionEvent(
        string $transactionId,
        string $eventType,
        array $event
    ): CashInTransactionEntityInterface{
        return $this
            ->cashInTransactionRepository
            ->addTransactionEvent(
                $transactionId,
                $eventType,
                $event
            );
    }

    /**
     * @inheritDoc
     */
    public function lookUpExtraInformationFor(
        array $criteria
    ): CashInTransactionEntityInterface{
        return $this
            ->cashInTransactionRepository
            ->lookUpExtraInformationFor(
                $criteria
            );
    }


    /**
     * @inheritDoc
     */
    public function updateTransactionStatus(
        string $transactionId,
        string $status
    ): CashInTransactionEntityInterface
    {
        return $this
            ->cashInTransactionRepository
            ->updateTransactionStatus(
                $transactionId,
                $status
            );
    }
}
