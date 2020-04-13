<?php


namespace Payment\CashIn\Transaction;


class CashInTransactionEntity implements CashInTransactionEntityInterface
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
     * CashInTransactionEntity constructor.
     * @param string $type
     * @param string $transactionId
     * @param float $amount
     * @param string $currency
     * @param string $description
     * @param string $accountId
     * @param array $originator
     * @param string $status
     * @param int $timestamp
     * @param array $extras
     */
    public function __construct(
        ?string $type,
        ?string $transactionId,
        ?float $amount,
        ?string $currency,
        ?string $description,
        ?string $accountId,
        ?array $originator,
        ?string $status,
        ?int $timestamp,
        ?array $extras
    ){
        $this->type = $type;
        $this->transactionId = $transactionId;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
        $this->accountId = $accountId;
        $this->originator = $originator;
        $this->status = $status;
        $this->timestamp = $timestamp;
        $this->extras = $extras;
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
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     * @return CashInTransactionEntity
     */
    public function setTransactionId(string $transactionId): CashInTransactionEntity
    {
        $this->transactionId = $transactionId;
        return $this;
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
}
