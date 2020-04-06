<?php

namespace Payment\Stripe\PaymentIntent\Service;


use Payment\Stripe\PaymentIntent\Entity\PaymentIntentInterface;
use stdClass;

interface PaymentIntentServiceInterface{

    /**
     * @param float $amount
     * @param string $currency
     * @param string $accountId
     * @return PaymentIntentInterface
     */
    public function create(
        float $amount,
        string $currency,
        string $accountId
    ): PaymentIntentInterface ;


    /**
     * @param string $clientSecret
     * @param string $eventType
     * @param array $event
     * @return PaymentIntentInterface
     */
    public function storeEvent(
        string $clientSecret,
        string $eventType,
        array $event
    ):PaymentIntentInterface;

    /**
     * @param string $clientSecret
     * @return PaymentIntentInterface
     */
    public function fromClientSecret(
        string $clientSecret
    ):PaymentIntentInterface;
}
