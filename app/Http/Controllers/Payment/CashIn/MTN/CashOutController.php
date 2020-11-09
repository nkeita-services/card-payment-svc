<?php


namespace App\Http\Controllers\Payment\CashIn\MTN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Payment\Account\Service\AccountService;
use Payment\Account\Service\AccountServiceInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionService;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;
use Payment\MTN\Collection\Service\CollectionService;
use Payment\MTN\Collection\Service\CollectionServiceInterface;
use Payment\MTN\Collection\Service\Exception\RequestToPayException;

class CashOutController extends Controller
{
    /**
     * @var CollectionServiceInterface
     */
    private $collectionService;

    /**
     * @var CashInTransactionServiceInterface
     */
    private $cashInTransactionService;

    /**
     *
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * IndexController constructor.
     * @param CollectionService $collectionService
     * @param CashInTransactionService $cashInTransactionService
     * @param AccountService $accountService
     */
    public function __construct(
        CollectionService $collectionService,
        CashInTransactionService $cashInTransactionService,
        AccountService $accountService
    ){
        $this->collectionService = $collectionService;
        $this->cashInTransactionService = $cashInTransactionService;
        $this->accountService = $accountService;
    }

    public function create(string $accountId, Request $request)
    {

        try {
            $cashInTransactionEntity = $this->collectionService->requestToPay(
                $accountId,
                $request->json('amount'),
                $request->json('originator')
            );

            $cashInTransactionEntity = $this->collectionService->requestToPayStatus(
                $cashInTransactionEntity->getTransactionId()
            );

            if($cashInTransactionEntity->isSuccessful()){
                $this
                    ->accountService
                    ->topUpFromCashInTransaction(
                        $cashInTransactionEntity
                    );
            }

        } catch (RequestToPayException $exception) {
            return response()->json([
                'status' => 'failure',
                'statusCode' => 10001,
                'statusDescription' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'CashIn' => [
                    'transactionId' => $cashInTransactionEntity->getTransactionId(),
                    'status'=> $cashInTransactionEntity->getStatus()
                ]
            ]
        ]);
    }
}
