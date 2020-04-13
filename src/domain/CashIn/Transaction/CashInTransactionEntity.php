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
     * CashInTransactionEntity constructor.
     * @param string $transactionId
     * @param float $amount
     * @param string $currency
     * @param string $description
     * @param string $accountId
     * @param array $originator
     */
    public function __construct(
        ?string $transactionId,
        ?float $amount,
        ?string $currency,
        ?string $description,
        ?string $accountId,
        ?array $originator
    ){
        $this->transactionId = $transactionId;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->description = $description;
        $this->accountId = $accountId;
        $this->originator = $originator;
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
}
