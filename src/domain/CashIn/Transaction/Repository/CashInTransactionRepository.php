<?php


namespace Payment\CashIn\Transaction\Repository;


use InvalidArgumentException;
use Payment\CashIn\Transaction\CashInTransactionEntity;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use MongoDB\Collection;
use MongoDB\BSON\ObjectId;
use Payment\CashIn\Transaction\Repository\Exception\CashInTransactionNotFoundException;

class CashInTransactionRepository implements
    CashInTransactionRepositoryInterface
{

    /**
     * @var Collection
     */
    private $cashInTransactionCollection;

    /**
     * CashInTransactionRepository constructor.
     * @param Collection $cashInTransactionCollection
     */
    public function __construct(Collection $cashInTransactionCollection)
    {
        $this->cashInTransactionCollection = $cashInTransactionCollection;
    }


    /**
     * @inheritDoc
     */
    public function store(
        CashInTransactionEntityInterface $transactionEntity
    ): CashInTransactionEntityInterface
    {
        $insertOneResult = $this->cashInTransactionCollection->insertOne(
            [
                'type' => $transactionEntity->getType(),
                'accountId' => $transactionEntity->getAccountId(),
                'amount' => $transactionEntity->getAmount(),
                'currency' => $transactionEntity->getCurrency(),
                'description' => $transactionEntity->getDescription(),
                'regions' => $transactionEntity->getRegions(),
                'originator' => $transactionEntity->getOriginator(),
                'status' => $transactionEntity->getStatus(),
                'timestamp' => $transactionEntity->getTimestamp(),
                'extras' => $transactionEntity->getExtras(),
                'events' => $transactionEntity->getEvents()
            ]
        );

        return $transactionEntity->setTransactionId(
            $insertOneResult->getInsertedId()
        );
    }

    /**
     * @inheritDoc
     */
    public function addExtras(
        string $transactionId,
        array $extras
    ): CashInTransactionRepositoryInterface
    {
        $this->cashInTransactionCollection->updateOne(
            ['_id' => new ObjectId($transactionId)],
            [
                '$set' => ['extras' => $extras]
            ]
        );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function fetchWithTransactionId(
        string $transactionId
    ): CashInTransactionEntityInterface
    {
        $transaction = $this->cashInTransactionCollection->findOne(
            ['_id' => new ObjectId($transactionId)]
        );

        return $this->createCashInTransactionEntityFromDocument(
            $transaction
        );
    }

    /**
     * @inheritDoc
     */
    public function fetchWithEventTypeAndEventId(
        string $eventType,
        string $eventId
    ): CashInTransactionEntityInterface
    {

        if (!array_key_exists($eventType, static::EVENT_TYPE_NAME_MAPPING)) {
            throw new InvalidArgumentException(
                sprintf('Invalid type %s', $eventType)
            );
        }

        $transaction = $this->cashInTransactionCollection->findOne(
            [
                'events' => [
                '$elemMatch' => [
                    'id' => $eventId, static::EVENT_TYPE_NAME_MAPPING[$eventType] => $eventType]
                ]

            ]
        );

        if (empty($transaction)) {
            throw new CashInTransactionNotFoundException(
                sprintf(
                    'CashIn transaction of type %s and Id %s  not found',
                    $eventType,
                    $eventId
                )
            );
        }
        return $this->createCashInTransactionEntityFromDocument(
            $transaction
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
        $this
            ->cashInTransactionCollection
            ->updateOne(
                ['_id' => new ObjectId($transactionId)],
                ['$push' => [
                    'events' => $event
                ]]
            );

        return $this->fetchWithTransactionId(
            $transactionId
        );
    }

    /**
     * @inheritDoc
     */
    public function lookUpExtraInformationFor(
        array $criteria
    ): CashInTransactionEntityInterface
    {
        $key = array_key_first($criteria);

        $transaction = $this->cashInTransactionCollection->findOne(
            [sprintf('extras.%s', $key) => $criteria[$key]]
        );

        return $this->createCashInTransactionEntityFromDocument(
            $transaction
        );
    }


    /**
     * @param $transaction
     * @return CashInTransactionEntity
     */
    private function createCashInTransactionEntityFromDocument(
        $transaction
    )
    {
        return new CashInTransactionEntity(
            $transaction->type,
            $transaction->_id->__toString(),
            $transaction->amount,
            $transaction->currency,
            $transaction->description,
            $transaction->accountId,
            $transaction->regions->getArrayCopy() ?? [],
            $transaction->originator->getArrayCopy(),
            $transaction->status,
            $transaction->timestamp,
            $transaction->extras->getArrayCopy(),
            $transaction->events->getArrayCopy() ?? []
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
        $this
            ->cashInTransactionCollection
            ->updateOne(
                ['_id' => new ObjectId($transactionId)],
                ['$set' => [
                    'status' => strtolower($status)
                ]]
            );

        return $this->fetchWithTransactionId(
            $transactionId
        );
    }

    /**
     * @inheritDoc
     */
    public function fetchAllWithTransactionTypeAndStatus(
        string $transactionType,
        string $transactionStatus
    ): array
    {
        $transactions = $this->cashInTransactionCollection->find(
            [
                'type' => $transactionType,
                'status' => $transactionStatus
            ],
            [
                'limit' => 10
            ]
        );

        return
            array_map(function ($transaction) {
                return $this->createCashInTransactionEntityFromDocument(
                    $transaction
                );
            }, $transactions->toArray());

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
        $this
            ->cashInTransactionCollection
            ->updateOne(
                ['_id' => new ObjectId($transactionId)],
                ['$push' => [
                    'events' =>  $fees
                ]]
            );

        return $this->fetchWithTransactionId(
            $transactionId
        );
    }
}
