<?php


namespace App\Http\Controllers\Payment\CashIn;


use Illuminate\Http\Request;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;

class GetTopUpFeesController
{
    /**
     * @var CashInTransactionServiceInterface
     */
    private $cashInTransactionService;

    /**
     * FetchCashInRequestController constructor.
     * @param CashInTransactionServiceInterface $cashInTransactionService
     */
    public function __construct(CashInTransactionServiceInterface $cashInTransactionService)
    {
        $this->cashInTransactionService = $cashInTransactionService;
    }

    public function fetchFromTransactionId(
        string $transactionId,
        Request $request
    )
    {
        try {
            $topUpFeesEntity = $this->cashInTransactionService->fetchFeesFromTopUpTransactionId(
                $transactionId
            );
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 'failure',
                'statusCode' => 10001,
                'statusDescription' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'Fees' => [
                    'amount'=> $topUpFeesEntity->toArray()
                ]
            ]
        ]);
    }
}
