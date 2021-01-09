<?php


namespace Payment\Wallet\Fee\Quote\Entity;


class QuoteFeeEntity implements QuoteFeeEntityInterface
{
    /**
     * @var array
     */
    private $walletOrganizations;

    /**
     * @var array
     */
    private $regions;

    /**
     * @var array
     */
    private $paymentMean;

    /**
     * @var array
     */
    private $nbk;

    /**
     * @var string
     */
    private $eventType;

    /**
     * @var string
     */
    private $transactionId;


    /**
     * OrganizationEntity constructor.
     * @param array|null $walletOrganizations
     * @param array|null $regions
     * @param array|null $paymentMean
     * @param array|null $nbk
     * @param string|null $eventType
     * @param string|null $transactionId
     */
    public function __construct(
        ?array $walletOrganizations = null,
        ?array $regions = null,
        ?array $paymentMean = null,
        ?array $nbk = null,
        ?string $eventType = null,
        ?string $transactionId = null

    ){
        $this->walletOrganizations = $walletOrganizations;
        $this->regions = $regions;
        $this->paymentMean = $paymentMean;
        $this->nbk = $nbk;
        $this->eventType = $eventType;
        $this->transactionId = $transactionId;
    }

    /**
     * @param array $data
     * @return QuoteFeeEntityInterface
     */
    public static function fromArray(array $data): QuoteFeeEntityInterface
    {
        return new static(
            $data['walletOrganizations'] ?? null,
            $data['regions'] ?? null,
            $data['paymentMean'] ?? null,
            $data['nbk'] ?? null,
            $data['eventType'] ?? null,
            $data['transactionId'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $quoteData =  [
            "walletOrganizations" => $this->walletOrganizations,
            "regions" => $this->regions,
            "paymentMean" =>$this->paymentMean,
            "nbk" => $this->nbk,
            "eventType" => $this->eventType,
            "transactionId" => $this->transactionId
        ];

        return array_filter(
            $quoteData,
            function ($propertyValue, $propertyName){
                return $propertyValue !== null;
            },
            ARRAY_FILTER_USE_BOTH
        );
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
     * @return array
     */
    public function getPaymentMean(): array
    {
        return $this->paymentMean;
    }

    /**
     * @return array
     */
    public function getNbk(): array
    {
        return $this->nbk;
    }

    /**
     * @return string
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }

    /**
     * @param string $eventType
     * @return QuoteFeeEntityInterface
     */
    public function setEventType(string $eventType): QuoteFeeEntityInterface
    {
        $this->eventType = $eventType;
        return $this;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     * @return QuoteFeeEntityInterface
     */
    public function setTransactionId(string $transactionId): QuoteFeeEntityInterface
    {
        $this->transactionId = $transactionId;
        return $this;
    }
}
