<?php


namespace Payment\CashIn\Transaction\Fees;


use MongoDB\Model\BSONDocument;


class CashInFeesEntity implements CashInFeesEntityInterface
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
     * CashInFeesEntity constructor.
     * @param array $walletOrganizations
     * @param array $regions
     * @param array $paymentMean
     * @param array $nbk
     */
    public function __construct(array $walletOrganizations, array $regions, array $paymentMean, array $nbk)
    {
        $this->walletOrganizations = $walletOrganizations;
        $this->regions = $regions;
        $this->paymentMean = $paymentMean;
        $this->nbk = $nbk;
    }

    /**
     * @inheritDoc
     */
    public static function fromMongoDBDocument(
        BSONDocument $document
    ): CashInFeesEntityInterface
    {
        $json = \MongoDB\BSON\toJSON(\MongoDB\BSON\fromPHP($document));
        return static::fromArray(
            json_decode(
                $json,
                true
            )
        );

    }

    /**
     * @inheritDoc
     */
    public static function fromArray(array $data): CashInFeesEntityInterface
    {
        return new static(
            $data['walletOrganizations'],
            $data['regions'],
            $data['paymentMean'],
            $data['nbk']
        );
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'regions'=> $this->regions,
            'paymentMean'=> $this->paymentMean,
            'nbk'=>$this->nbk
        ];
    }


}
