<?php


namespace Payment\Payment\PaymentCommon\Entity;


interface PaymentInterface
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
     * @return Payment
     */
    public function setPublishableKey(string $publishableKey): Payment;

    /**
     * @param $document
     * @return PaymentInterface
     */
    public static function fromStdClass($document): PaymentInterface;
}
