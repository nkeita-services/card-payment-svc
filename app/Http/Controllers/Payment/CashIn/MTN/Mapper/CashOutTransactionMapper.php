<?php


namespace App\Http\Controllers\Payment\CashIn\MTN\Mapper;


use Illuminate\Http\Request;
use Payment\CashOut\Transaction\Entity\CashOutTransactionEntity;
use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;

class CashOutTransactionMapper implements CashOutTransactionMapperInterface
{

    /**
     * @inheritDoc
     */
    public static function createCashOutTransactionFromHttpRequest(
        string $accountId,
        Request $request
    ): CashOutTransactionEntityInterface
    {
        return new CashOutTransactionEntity(
            CashOutTransactionEntityInterface::TYPE_MTN,
            null,
            $request->json('amount'),
            null,
            $request->json('description'),
            $accountId,
            $request->json('originator'),
            CashOutTransactionEntityInterface::STATUS_PENDING,
             time()
        );
    }
}
