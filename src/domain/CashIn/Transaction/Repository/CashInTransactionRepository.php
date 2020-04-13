<?php


namespace Payment\CashIn\Transaction\Repository;


use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use MongoDB\Collection;

class CashInTransactionRepository implements CashInTransactionRepositoryInterface
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
    ): CashInTransactionEntityInterface{
        $insertOneResult = $this->cashInTransactionCollection->insertOne(
            [
                'type'=>$transactionEntity->getType(),
                'accountId' => $transactionEntity->getAccountId(),
                'amount' => $transactionEntity->getAmount(),
                'currency' => $transactionEntity->getCurrency(),
                'description' => $transactionEntity->getDescription(),
                'originator'=>$transactionEntity->getOriginator(),
                'status'=> $transactionEntity->getStatus(),
                'timestamp'=> $transactionEntity->getTimestamp(),
                'extras'=>$transactionEntity->getExtras()
            ]
        );

        return $transactionEntity->setTransactionId(
            $insertOneResult->getInsertedId()
        );;
    }
}
