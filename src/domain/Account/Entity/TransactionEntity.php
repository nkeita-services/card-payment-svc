<?php


namespace Payment\Account\Entity;


class TransactionEntity implements TransactionEntityInterface
{
    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $accountId;

    /**
     * @var string
     */
    private $amount;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $originator;

    /**
     * @var string
     */
    private $originatorId;

    /**
     * TransactionEntity constructor.
     * @param string $userId
     * @param string $accountId
     * @param string $amount
     * @param string $description
     * @param string $originator
     * @param string $originatorId
     */
    public function __construct(
        string $userId,
        string $accountId,
        string $amount,
        string $description,
        string $originator,
        string $originatorId){
        $this->userId = $userId;
        $this->accountId = $accountId;
        $this->amount = $amount;
        $this->description = $description;
        $this->originator = $originator;
        $this->originatorId = $originatorId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getAccountId(): string
    {
        return $this->accountId;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
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
    public function getOriginator(): string
    {
        return $this->originator;
    }

    /**
     * @return string
     */
    public function getOriginatorId(): string
    {
        return $this->originatorId;
    }

}
