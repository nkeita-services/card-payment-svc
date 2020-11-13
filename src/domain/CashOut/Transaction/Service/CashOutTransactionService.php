<?php


namespace Payment\CashOut\Transaction\Service;



use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;
use Payment\CashOut\Transaction\Repository\CashOutTransactionRepositoryInterface;

class CashOutTransactionService implements CashOutTransactionServiceInterface
{

    /**
     * @var CashOutTransactionRepositoryInterface
     */
    private $CashOutTransactionRepository;

    /**
     * CashOutTransactionService constructor.
     * @param CashOutTransactionRepositoryInterface $CashOutTransactionRepository
     */
    public function __construct(
        CashOutTransactionRepositoryInterface $CashOutTransactionRepository
    ){
        $this->CashOutTransactionRepository = $CashOutTransactionRepository;
    }


    /**
     * @inheritDoc
     */
    public function store(
        CashOutTransactionEntityInterface $transactionEntity
    ): CashOutTransactionEntityInterface{
        return $this
            ->CashOutTransactionRepository
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
            ->CashOutTransactionRepository
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
    ): CashOutTransactionEntityInterface{
        return $this
            ->CashOutTransactionRepository
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
    ): CashOutTransactionEntityInterface{
        return $this
            ->CashOutTransactionRepository
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
    ): CashOutTransactionEntityInterface{
        return $this
            ->CashOutTransactionRepository
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
    ): CashOutTransactionEntityInterface
    {
        return $this
            ->CashOutTransactionRepository
            ->updateTransactionStatus(
                $transactionId,
                $status
            );
    }

    /**
     * @inheritDoc
     */
    public function fetchPendingTransactionFor(string $transactionType): array
    {
        return $this
            ->CashOutTransactionRepository
            ->fetchAllWithTransactionTypeAndStatus(
                $transactionType,
                'pending'
            );
    }
}
