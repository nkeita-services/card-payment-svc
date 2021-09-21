<?php


namespace Payment\CashOut\Transaction\Entity;


use Payment\CashIn\Transaction\CashInTransactionEntity;

class CashOutTransactionEntity implements CashOutTransactionEntityInterface
{

    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $transactionId;
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
    private $description;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var array
     */
    private $regions;

    /**
     * @var array
     */
    private $originator;

    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $timestamp;

    /**
     * @var array
     */
    private $extras;

    /**
     * @var array
     */
    private $events;


    /**
     * CashInTransactionEntity constructor.
     * @param string $type
     * @param string $transactionId
     * @param float $amount
     * @param string $currency
     * @param string $description
     * @param string $accountId
     * @param array|null $regions
     * @param array $originator
     * @param string $status
     * @param int $timestamp
     * @param array $extras
     * @param array $events
     */
    public function __construct(
        ?string $type,
        ?string $transactionId,
        ?float $amount,
        ?string $currency,
        ?string $description,
        ?string $accountId,
        ?array $regions,
        ?array $originator,
        ?string $status,
        ?int $timestamp,
        array $extras = [],
        array $events = []
    ){
        $this->type = $type;
        $this->transactionId = $transactionId;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
        $this->accountId = $accountId;
        $this->regions = $regions;
        $this->originator = $originator;
        $this->status = $status;
        $this->timestamp = $timestamp;
        $this->extras = $extras;
        $this->events = $events;
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * @return array
     */
    public function getOriginator(): array
    {
        return $this->originator;
    }

    /**
     * @inheritDoc
     */
    public function getOriginatorId(): string
    {
        return $this->originator['originatorId'];
    }

    /**
     * @inheritDoc
     */
    public function getOriginatorExternalMobileNumber(): ?string
    {
        return $this->originator['mobileNumber'] ?? null;
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
     * @return CashOutTransactionEntityInterface
     */
    public function setTransactionId(string $transactionId): CashOutTransactionEntityInterface
    {
        $this->transactionId = $transactionId;
        return $this;
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
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * @return array
     */
    public function getExtras(): ?array
    {
        return $this->extras;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @inheritDoc
     */
    public function isSuccessful(): bool
    {
        return $this->status == 'successful';
    }


    /**
     * @inheritDoc
     */
    public function setCurrency(
        string $currency
    ): CashOutTransactionEntityInterface
    {
        $this->currency = $currency;
        return $this;
    }


    /**
     * @return array
     */
    public function getEvents(): ?array
    {
        return $this->events;
    }
}
