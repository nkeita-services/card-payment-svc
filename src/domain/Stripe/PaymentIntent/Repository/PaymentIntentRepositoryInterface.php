<?php


namespace Payment\Stripe\PaymentIntent\Repository;

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
     * @return string
     */
    public function updateWithClientSecret(
        string $clientSecret,
        array $data
    ):string;

    /**
     * @param array $filters
     * @return stdClass
     */
    public function find(
        array $filters
    ):stdClass;
}
