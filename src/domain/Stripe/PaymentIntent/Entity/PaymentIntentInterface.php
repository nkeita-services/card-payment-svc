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

    /**
     * @param string $publishableKey
     * @return PaymentIntent
     */
    public function setPublishableKey(string $publishableKey): PaymentIntent;

    /**
     * @param $document
     * @return PaymentIntentInterface
     */
    public static function fromStdClass($document): PaymentIntentInterface;
}
