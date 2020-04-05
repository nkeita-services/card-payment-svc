<?php


namespace Payment\Stripe\PaymentIntent\Entity;


interface PaymentIntentInterface
{
    /**
     * @return string
     */
    public function getClientSecret(): string;

    /**
     * @return string
     */
    public function getPublishableKey(): string;

    /**
     * @return float
     */
    public function getAmount(): float;

    /**
     * @return string
     */
    public function getAccountId(): string;
}
