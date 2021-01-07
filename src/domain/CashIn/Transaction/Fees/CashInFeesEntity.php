<?php


namespace Payment\CashIn\Transaction\Fees;


class CashInFeesEntity implements CashInFeesEntityInterface
{

    private $amount;

    /**
     * CashInFeesEntity constructor.
     * @param $amount
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }


    /**
     * @inheritDoc
     */
    public function amount(): float
    {
        return $this->amount;
    }
}
