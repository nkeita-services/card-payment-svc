<?php


namespace Payment\Stripe\PaymentIntent\Repository;


use MongoDB\Collection;
use stdClass;

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
    ): string{
        $updateResult = $this
            ->paymentIntentCollection
            ->updateOne(
                ['clientSecret' => $clientSecret],
                ['$set' => $data]
            );

        return $updateResult->getUpsertedId();
    }
    /**
     * @inheritDoc
     */
    public function find(array $filters): stdClass
    {
        return $this
            ->paymentIntentCollection
            ->findOne(
                $filters
            );
    }


}
