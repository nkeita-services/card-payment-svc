<?php


namespace App\Http\Controllers\Payment\CashIn\MTN\Mapper;


use Illuminate\Http\Request;
use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;

interface CashOutTransactionMapperInterface
{

    /**
     * @param string $accountId
     * @param Request $request
     * @return CashOutTransactionEntityInterface
     */
    public static function createCashOutTransactionFromHttpRequest(
        string $accountId,
        Request $request
    ): CashOutTransactionEntityInterface;
}
