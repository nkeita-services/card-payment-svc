<?php


namespace Payment\MTN\Remittance\Entity;


class MTNTransferEntity implements MTNTransferEntityInterface
{

    /**
     * @var float
     */
    private $amount;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $partyIdType;

    /**
     * @var string
     */
    private $partyId;

    /**
     * @var string
     */
    private $payerMessage;

    /**
     * @var string
     */
    private $payeeNote;

    /**
     * @var string
     */
    private $externalId;

    /**
     * RequestToPayEntity constructor.
     * @param float $amount
     * @param string $currency
     * @param string $partyIdType
     * @param string $partyId
     * @param string $payerMessage
     * @param string $payeeNote
     * @param string $externalId
     */
    public function __construct(
        float $amount = null,
        string $currency = null,
        string $partyIdType = null,
        string $partyId = null,
        string $payerMessage = null,
        string $payeeNote = null,
        string $externalId = null){
        $this->amount = $amount;
        $this->currency = $currency;
        $this->partyIdType = $partyIdType;
        $this->partyId = $partyId;
        $this->payerMessage = $payerMessage;
        $this->payeeNote = $payeeNote;
        $this->externalId = $externalId;
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
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getPartyIdType(): string
    {
        return $this->partyIdType;
    }

    /**
     * @return string
     */
    public function getPartyId(): string
    {
        return $this->partyId;
    }

    /**
     * @return string
     */
    public function getPayerMessage(): string
    {
        return $this->payerMessage;
    }

    /**
     * @return string
     */
    public function getPayeeNote(): string
    {
        return $this->payeeNote;
    }

    /**
     * @return string
     */
    public function getExternalId(): string
    {
        return $this->externalId;
    }
}
