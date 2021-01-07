<?php


namespace Payment\CashIn\Transaction\Fees;


interface CashInFeesEntityInterface
{

    /**
     * @return float
     */
    public function amount(): float ;
}
