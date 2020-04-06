<?php


namespace Payment\Stripe\PaymentIntent\Repository;

use Payment\Stripe\PaymentIntent\Entity\PaymentIntentInterface;
use stdClass;

interface PaymentIntentRepositoryInterface
{

    /**
     * @param string $clientSecret
     * @param float $amount
     * @param string $currency
     * @param string $accountId
     * @return string
     */
    public function store(
        string $clientSecret,
        float $amount,
        string $currency,
        string $accountId
    ):string ;

    /**
     * @param string $clientSecret
     * @param array $data
     * @return int
     */
    public function updateWithClientSecret(
        string $clientSecret,
        array $data
    ):int;

    /**
     * @param array $filters
     * @return PaymentIntentInterface
     */
    public function find(
        array $filters
    ):PaymentIntentInterface;
}
