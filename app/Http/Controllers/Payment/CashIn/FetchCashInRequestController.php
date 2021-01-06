<?php


namespace App\Http\Controllers\Payment\CashIn;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Payment\Account\Service\AccountServiceInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionService;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;
use Payment\MTN\Collection\Service\CollectionService;
use Payment\MTN\Collection\Service\CollectionServiceInterface;
use Payment\MTN\Collection\Service\Exception\RequestToPayException;

class FetchCashInRequestController extends Controller
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


    public function fetchFromEventTypeAndEventId(
        string $eventType,
        string $eventId,
        Request $request)
    {
        try {
            $cashInTransactionEntity = $this->cashInTransactionService->fetchWithEventTypeAndEventId(
                $eventType,
                $eventId
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
                'CashIn' => $cashInTransactionEntity->toArray()
            ]
        ]);
    }
}
