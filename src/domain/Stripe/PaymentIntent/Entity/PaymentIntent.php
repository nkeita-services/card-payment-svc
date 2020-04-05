<?php


namespace Payment\Stripe\PaymentIntent\Entity;


class PaymentIntent implements PaymentIntentInterface
{

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string
     */
    private $publishableKey;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $accountId;

    /**
     * PaymentIntent constructor.
     * @param string $clientSecret
     * @param float $amount
     * @param string $accountId
     * @param string $publishableKey
     */
    public function __construct(
        string $clientSecret,
        float $amount,
        string $accountId,
        string $publishableKey = null
    ){
        $this->clientSecret = $clientSecret;
        $this->publishableKey = $publishableKey;
        $this->amount = $amount;
        $this->accountId = $accountId;
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


}
