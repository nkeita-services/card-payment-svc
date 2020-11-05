<?php


namespace Payment\Payment\PaymentCommon\Repository;


use Payment\Payment\PaymentCommon\Entity\PaymentInterface;

interface PaymentRepositoryInterface
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
     * @param array $filter
     * @param array $data
     * @return int
     */
    public function updateWithFilter(
        array $filter,
        array $data
    ):int;

    /**
     * @param array $filters
     * @return PaymentInterface
     */
    public function find(
        array $filters
    ):PaymentInterface;
}
