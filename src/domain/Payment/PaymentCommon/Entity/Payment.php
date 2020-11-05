<?php


namespace Payment\Payment\PaymentCommon\Entity;


class Payment implements PaymentInterface
{
    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $publishableKey;

    /**
     * PaymentIntent constructor.
     * @param string $clientSecret
     * @param float $amount
     * @param string $accountId
     * @param string $currency
     * @param string $publishableKey
     */
    public function __construct(
        string $clientSecret,
        float $amount,
        string $accountId,
        string $currency,
        string $publishableKey = null){

        $this->clientSecret = $clientSecret;
        $this->amount = $amount;
        $this->accountId = $accountId;
        $this->currency = $currency;
        $this->publishableKey = $publishableKey;
    }

    /**
     * @inheritDoc
     */
    public static function fromStdClass($document): PaymentInterface
    {
        return new static(
            $document->clientSecret,
            $document->amount,
            $document->accountId,
            $document->currency
        );
    }


    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @return string
     */
    public function getPublishableKey(): string
    {
        return $this->publishableKey;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * @param string $publishableKey
     * @return Payment
     */
    public function setPublishableKey(string $publishableKey): Payment
    {
        $this->publishableKey = $publishableKey;
        return $this;
    }
}
