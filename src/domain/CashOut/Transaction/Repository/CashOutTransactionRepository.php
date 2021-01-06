<?php


namespace Payment\CashOut\Transaction\Repository;


use MongoDB\Collection;
use MongoDB\BSON\ObjectId;
use Payment\CashOut\Transaction\Entity\CashOutTransactionEntity;
use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;

class CashOutTransactionRepository implements
    CashOutTransactionRepositoryInterface
{

    /**
     * @var Collection
     */
    private $cashOutTransactionCollection;

    /**
     * CashInTransactionRepository constructor.
     * @param Collection $cashOutTransactionCollection
     */
    public function __construct(Collection $cashOutTransactionCollection)
    {
        $this->cashOutTransactionCollection = $cashOutTransactionCollection;
    }


    /**
     * @inheritDoc
     */
    public function store(
        CashOutTransactionEntityInterface $transactionEntity
    ): CashOutTransactionEntityInterface
    {
        $insertOneResult = $this->cashOutTransactionCollection->insertOne(
            [
                'type' => $transactionEntity->getType(),
                'accountId' => $transactionEntity->getAccountId(),
                'amount' => $transactionEntity->getAmount(),
                'currency' => $transactionEntity->getCurrency(),
                'description' => $transactionEntity->getDescription(),
                'regions'  => $transactionEntity->getRegions(),
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
    ): CashOutTransactionRepositoryInterface
    {
        $this->cashOutTransactionCollection->updateOne(
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
    ): CashOutTransactionEntityInterface
    {
        $transaction = $this->cashOutTransactionCollection->findOne(
            ['_id' => new ObjectId($transactionId)]
        );

        return $this->createCashOutTransactionEntityFromDocument(
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
    ): CashOutTransactionEntityInterface
    {
        $this
            ->cashOutTransactionCollection
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
    ): CashOutTransactionEntityInterface
    {
        $transaction = $this->cashOutTransactionCollection->findOne(
            ['extras.clientSecret' => $criteria['clientSecret']]
        );

        return $this->createCashOutTransactionEntityFromDocument(
            $transaction
        );
    }


    /**
     * @param $transaction
     * @return CashOutTransactionEntityInterface
     */
    private function createCashOutTransactionEntityFromDocument(
        $transaction
    )
    {
        return new CashOutTransactionEntity(
            $transaction->type,
            $transaction->_id->__toString(),
            $transaction->amount,
            $transaction->currency,
            $transaction->description,
            $transaction->accountId,
            $transaction->regions,
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
    ): CashOutTransactionEntityInterface
    {
        $this
            ->cashOutTransactionCollection
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
        $transactions = $this->cashOutTransactionCollection->find(
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
                return $this->createCashOutTransactionEntityFromDocument(
                    $transaction
                );
            }, $transactions->toArray());

    }

    /**
     * @param string $transactionId
     * @param array $fees
     * @return CashOutTransactionEntityInterface
     */
    public function addTransactionFees(
        string $transactionId,
        array $fees
    ):CashOutTransactionEntityInterface
    {
        $this
            ->cashOutTransactionCollection
            ->updateOne(
                ['_id' => new ObjectId($transactionId)],
                ['$addToSet' => [
                    'fees' => $fees
                ]]
            );

        return $this->fetchWithTransactionId(
            $transactionId
        );
    }
}
