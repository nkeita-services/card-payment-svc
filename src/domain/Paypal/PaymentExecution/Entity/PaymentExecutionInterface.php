<?php


namespace Payment\Paypal\PaymentExecution\Entity;


interface PaymentExecutionInterface
{
    /**
     * @return string
     */
    public function getCurrencyCode(): string;

    /**
     * @return float
     */
    public function getValue(): float ;

    /**
     * @return string
     */
    public function getAccountId(): string;

    /**
     * @return string
     */
    public function getReturnUrl(): ?string;

    /**
     * @return string
     */
    public function getCancelUrl(): ?string;

}
