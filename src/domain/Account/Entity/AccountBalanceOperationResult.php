<?php


namespace Payment\Account\Entity;


class AccountBalanceOperationResult implements AccountBalanceOperationResultInterface
{

    /**
     * @var AccountEntityInterface
     */
    private $account;

    /**
     * @var array
     */
    private $transactionDetails;

    /**
     * AccountBalanceOperationResult constructor.
     * @param AccountEntityInterface $account
     * @param array $transactionDetails
     */
    public function __construct(AccountEntityInterface $account, array $transactionDetails)
    {
        $this->account = $account;
        $this->transactionDetails = $transactionDetails;
    }


    /**
     * @inheritDoc
     */
    public function account(): AccountEntityInterface
    {
        return $this->account;
    }

    /**
     * @inheritDoc
     */
    public function transactionDetails(): array
    {
        return $this->transactionDetails;
    }

    /**
     * @inheritDoc
     */
    public function transactionId(): string
    {
        $transactionDetails =  $this->transactionDetails;
        return $transactionDetails['transactionId'];
    }


}
