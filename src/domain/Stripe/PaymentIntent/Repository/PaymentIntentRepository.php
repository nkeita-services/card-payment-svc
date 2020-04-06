<?php


namespace Payment\Stripe\PaymentIntent\Repository;


use MongoDB\Collection;
use Payment\Stripe\PaymentIntent\Entity\PaymentIntent as Intent;
use Payment\Stripe\PaymentIntent\Entity\PaymentIntentInterface;

class PaymentIntentRepository implements PaymentIntentRepositoryInterface
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
        string $clientSecret,
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
    public function find(array $filters): PaymentIntentInterface
    {
        $result =  $this
            ->paymentIntentCollection
            ->findOne(
                $filters
            );

        return Intent::fromStdClass($result);
    }
}
