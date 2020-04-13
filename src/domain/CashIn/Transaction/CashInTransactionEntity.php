<?php


namespace Payment\CashIn\Transaction;


class CashInTransactionEntity implements CashInTransactionEntityInterface
{

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
     * CashInTransactionEntity constructor.
     * @param string $transactionId
     * @param float $amount
     * @param string $currency
     * @param string $description
     * @param string $accountId
     * @param array $originator
     * @param string $status
     * @param int $timestamp
     */
    public function __construct(
        ?string $transactionId,
        ?float $amount,
        ?string $currency,
        ?string $description,
        ?string $accountId,
        ?array $originator,
        ?string $status,
        ?int $timestamp
    ){
        $this->transactionId = $transactionId;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
        $this->accountId = $accountId;
        $this->originator = $originator;
        $this->status = $status;
        $this->timestamp = $timestamp;
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
}
