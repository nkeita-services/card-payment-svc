<?php


namespace Payment\Paypal\PaymentExecution\Entity;


class PaymentExecution implements PaymentExecutionInterface
{
    /**
     * @var string
     */
    private $currency_code;

    /**
     * @var float
     */
    private $value;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $returnUrl;

    /**
     * @var string
     */
    private $cancelUrl;

    /**
     * PaymentExecution constructor.
     * @param float $value
     * @param string $currency_code
     * @param string $accountId
     * @param string $returnUrl
     * @param string $cancelUrl
     */
    public function __construct(
        float $value,
        string $currency_code,
        string $accountId,
        ?string $returnUrl,
        ?string $cancelUrl
    ){
        $this->value            = $value;
        $this->currency_code    = $currency_code;
        $this->accountId        = $accountId;
        $this->returnUrl        = $returnUrl;
        $this->cancelUrl        = $cancelUrl;
    }

    /**
     * @return string
     */
    public function getCurrencyCode(): string
    {
        return $this->currency_code;
    }

    /**
     * @return float
     */
    public function getValue(): float
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * @return string
     */
    public function getReturnUrl(): ?string
    {
        return $this->returnUrl;
    }

    /**
     * @return string
     */
    public function getCancelUrl(): ?string
    {
        return $this->cancelUrl;
    }

}
