<?php


namespace Payment\Wallet\Fee\Quote\Entity;


class QuoteFeeEntity implements QuoteFeeEntityInterface
{
    /**
     * @var array
     */
    private $walletOrganizations;

    /**
     * @var string
     */
    private $regionId;

    /**
     * @var array
     */
    private $paymentMean;

    /**
     * @var array
     */
    private $nbk;


    /**
     * OrganizationEntity constructor.
     * @param array|null $walletOrganizations
     * @param string $regionId
     * @param array|null $paymentMean
     * @param array|null $nbk
     */
    public function __construct(
        ?array $walletOrganizations = null,
        ?string $regionId = null,
        ?array $paymentMean = null,
        ?array $nbk = null
    ){
        $this->walletOrganizations = $walletOrganizations;
        $this->regionId = $regionId;
        $this->paymentMean = $paymentMean;
        $this->nbk = $nbk;
    }

    /**
     * @param array $data
     * @return QuoteFeeEntityInterface
     */
    public static function fromArray(array $data): QuoteFeeEntityInterface
    {
        return new static(
            $data['walletOrganizations'] ?? null,
            $data['regionId'] ?? null,
            $data['paymentMean'] ?? null,
            $data['nbk'] ?? null
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $quoteData =  [
            "walletOrganizations"=> $this->walletOrganizations,
            "regionId"=> $this->regionId,
            "paymentMean"=>$this->paymentMean,
            "nbk"=>$this->nbk
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
     * @return string
     */
    public function getRegionId(): string
    {
        return $this->regionId;
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
}
