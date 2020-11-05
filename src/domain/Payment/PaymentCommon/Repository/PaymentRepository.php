<?php


namespace Payment\Payment\PaymentCommon\Repository;


use MongoDB\Collection;
use Payment\Payment\PaymentCommon\Entity\PaymentInterface;
use Payment\Payment\PaymentCommon\Entity\Payment;


class PaymentRepository implements PaymentRepositoryInterface
{
    /**
     * @var Collection
     */
    private $paymentIntentCollection;

    /**
     * PaymentIntentRepository constructor.
     * @param Collection $paymentIntentCollection
     */
    public function __construct(
        Collection $paymentIntentCollection
    )
    {
        $this->paymentIntentCollection = $paymentIntentCollection;
    }

    /**
     * @inheritDoc
     */
    public function store(
        string $clientSecret,
        float $amount,
        string $currency,
        string $accountId
    ): string
    {
        $insertOneResult = $this->paymentIntentCollection->insertOne(
            [
                'clientSecret' => $clientSecret,
                'amount' => $amount,
                'currency' => $currency,
                'accountId' => $accountId
            ]
        );

        return $insertOneResult->getInsertedId();
    }

    /**
     * @inheritDoc
     */
    public function updateWithClientSecret(
        array $clientSecret,
        array $data
    ): int{
        $updateResult = $this
            ->paymentIntentCollection
            ->updateOne(
                ['clientSecret' => $clientSecret],
                ['$addToSet' => $data]
            );

        return $updateResult->getUpsertedCount();
    }
    /**
     * @inheritDoc
     */
    public function find(array $filters): PaymentInterface
    {
        $result =  $this
            ->paymentIntentCollection
            ->findOne(
                $filters
            );

        return Payment::fromStdClass($result);
    }
}
