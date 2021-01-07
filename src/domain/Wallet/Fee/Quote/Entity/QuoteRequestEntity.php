<?php


namespace Payment\Wallet\Fee\Quote\Entity;


class QuoteRequestEntity implements QuoteRequestEntityInterface
{
    /**
     * @var string
     */
    private $paymentMean;

    /**
     * @var array
     */
    private $walletOrganizations;

    /**
     * @var array
     */
    private $regions;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $operation;

    /**
     * @var string
     */
    private $originator;

    /**
     * TransactionEntity constructor.
     * @param string $paymentMean
     * @param string $amount
     * @param string $accountId
     * @param array $walletOrganizations
     * @param array $regions
     * @param string $operation
     * @param string $currency
     * @param array $originator
     */
    public function __construct(
        ?string $paymentMean,
        ?string $amount,
        ?string $accountId,
        ?array $walletOrganizations,
        ?array $regions,
        ?string $operation,
        ?string $currency,
        ?array $originator
    ){
        $this->paymentMean = $paymentMean;
        $this->walletOrganizations = $walletOrganizations;
        $this->regions = $regions;
        $this->currency = $currency;
        $this->accountId = $accountId;
        $this->amount = $amount;
        $this->operation = $operation;
        $this->originator = $originator;
    }


    /**
     * @param array $data
     * @return QuoteRequestEntityInterface
     */
    public static function fromArray(
        array $data): QuoteRequestEntityInterface
    {
        return new static(
            $data['paymentMean'] ?? null,
            $data['amount'] ?? null,
            $data['accountId'] ?? null,
            $data['walletOrganizations'] ?? null,
            $data['regions'] ?? null,
            $data['operation'] ?? null,
            $data['currency'] ?? null,
            $data['originator'] ?? null

        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $transactionData =  [
            "paymentMean"=> ucfirst(strtolower($this->paymentMean)),
            "amount"=> floatval($this->amount),
            "accountId"=>$this->currency,
            "walletOrganizations"=>$this->walletOrganizations,
            "regions"=>$this->regions,
            'operation'=>$this->operation,
            'currency'=>$this->currency,
            'originator'=>$this->originator
        ];

        return array_filter(
            $transactionData,
            function ($propertyValue, $propertyName){
                return $propertyValue !== null;
            },
            ARRAY_FILTER_USE_BOTH
        );
    }

    /**
     * @return string
     */
    public function getPaymentMean(): string
    {
        return $this->paymentMean;
    }

    /**
     * @param string $paymentMean
     * @return QuoteRequestEntityInterface
     */
    public function setPaymentMean(string $paymentMean): QuoteRequestEntityInterface
    {
        $this->paymentMean = $paymentMean;
        return $this;
    }

    /**
     * @return array
     */
    public function getWalletOrganizations(): array
    {
        return $this->walletOrganizations;
    }

    /**
     * @return array
     */
    public function getRegions(): array
    {
        return $this->regions;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
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
    public function getOperation(): string
    {
        return $this->operation;
    }

    /**
     * @return string
     */
    public function getOriginator(): string
    {
        return $this->originator;
    }
}
