<?php


namespace Payment\CashIn\Transaction\Service;


use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashIn\Transaction\Fees\CashInFeesEntity;
use Payment\CashIn\Transaction\Fees\CashInFeesEntityInterface;
use Payment\CashIn\Transaction\Repository\CashInTransactionRepositoryInterface;

class CashInTransactionService implements CashInTransactionServiceInterface
{

    /**
     * @var CashInTransactionRepositoryInterface
     */
    private $cashInTransactionRepository;

    /**
     * CashOutTransactionService constructor.
     * @param CashInTransactionRepositoryInterface $cashInTransactionRepository
     */
    public function __construct(
        CashInTransactionRepositoryInterface $cashInTransactionRepository
    )
    {
        $this->cashInTransactionRepository = $cashInTransactionRepository;
    }


    /**
     * @inheritDoc
     */
    public function store(
        CashInTransactionEntityInterface $transactionEntity
    ): CashInTransactionEntityInterface
    {
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
    ): void
    {
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
    ): CashInTransactionEntityInterface
    {
        return $this
            ->cashInTransactionRepository
            ->fetchWithTransactionId(
                $transactionId
            );
    }

    /**
     * @inheritDoc
     */
    public function fetchWithEventTypeAndEventId(
        string $eventType,
        string $eventId): CashInTransactionEntityInterface
    {
        return $this
            ->cashInTransactionRepository
            ->fetchWithEventTypeAndEventId(
                $eventType,
                $eventId
            );
    }

    /**
     * @inheritDoc
     */
    public function fetchFeesFromTopUpTransactionId(
        string $transactionId
    ): CashInFeesEntityInterface
    {
        $eventType = 'CAPTURE';
        $eventTypeName = CashInTransactionRepositoryInterface::EVENT_TYPE_NAME_MAPPING[$eventType];

        $cashInTransaction = $this
            ->fetchWithEventTypeAndEventId(
                $eventType,
                $transactionId
            );

        $feesEvent = array_filter(
            $cashInTransaction->getEvents(),
            function ($event) use ($eventTypeName, $eventType) {
                if (array_key_exists($eventTypeName, $event)) {
                    return $event->{$eventTypeName} == $eventType;
                }
                return false;
            }
        );

        if(empty($feesEvent)){
            throw new \DomainException(
                sprintf('No fee event found for %s', $transactionId)
            );
        }

        $feesEvent = current($feesEvent);

        return new CashInFeesEntity(
            $feesEvent['amount']
        );

    }


    /**
     * @inheritDoc
     */
    public function addTransactionEvent(
        string $transactionId,
        string $eventType,
        array $event
    ): CashInTransactionEntityInterface
    {
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
    ): CashInTransactionEntityInterface
    {
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

    /**
     * @inheritDoc
     */
    public function fetchPendingTransactionFor(string $transactionType): array
    {
        return $this
            ->cashInTransactionRepository
            ->fetchAllWithTransactionTypeAndStatus(
                $transactionType,
                'pending'
            );
    }

    /**
     * @param string $transactionId
     * @param array $fees
     * @return CashInTransactionEntityInterface
     */
    public function addTransactionFees(
        string $transactionId,
        array $fees
    ): CashInTransactionEntityInterface
    {
        return $this
            ->cashInTransactionRepository
            ->addTransactionFees(
                $transactionId,
                $fees
            );
    }
}
