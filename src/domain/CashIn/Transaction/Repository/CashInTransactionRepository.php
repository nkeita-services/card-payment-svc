<?php


namespace Payment\CashIn\Transaction\Repository;


use Payment\CashIn\Transaction\CashInTransactionEntity;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use MongoDB\Collection;
use MongoDB\BSON\ObjectId;

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
                'originator' => $transactionEntity->getOriginator(),
                'status' => $transactionEntity->getStatus(),
                'timestamp' => $transactionEntity->getTimestamp(),
                'extras' => $transactionEntity->getExtras()
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
                ['$addToSet' => [
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
        $transaction = $this->cashInTransactionCollection->findOne(
            ['extras.clientSecret' => $criteria['clientSecret']]
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
            $transaction->originator->getArrayCopy(),
            $transaction->status,
            $transaction->timestamp,
            $transaction->extras->getArrayCopy()
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
}
