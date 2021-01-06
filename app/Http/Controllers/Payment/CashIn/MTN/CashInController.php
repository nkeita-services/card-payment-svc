<?php


namespace App\Http\Controllers\Payment\CashIn\MTN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Payment\Account\Service\AccountService;
use Payment\Account\Service\AccountServiceInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionService;
use Payment\CashIn\Transaction\Service\CashOutTransactionServiceInterface;
use Payment\MTN\Collection\Service\CollectionService;
use Payment\MTN\Collection\Service\CollectionServiceInterface;
use Payment\MTN\Collection\Service\Exception\RequestToPayException;

class CashInController extends Controller
{

    /**
     * @var CollectionServiceInterface
     */
    private $collectionService;

    /**
     * @var CashOutTransactionServiceInterface
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
    )
    {
        $this->collectionService = $collectionService;
        $this->cashInTransactionService = $cashInTransactionService;
        $this->accountService = $accountService;
    }


    public function form(
        float $amount,
        string $currency,
        string $accountId,
        string $userId
    )
    {

        return view(
            'mtn/collection_widget',
            [
                'amount' => $amount,
                'currency' => $currency,
                'accountId' => $accountId,
                'userId' => $userId
            ]);
    }

    public function create(string $accountId, Request $request)
    {

        try {
            $cashInTransactionEntity = $this->collectionService->requestToPay(
                $accountId,
                $request->json('amount'),
                $request->json('originator'),
                $request->json()->get('regionId')
            );

            $cashInTransactionEntity = $this->collectionService->requestToPayStatus(
                $cashInTransactionEntity->getTransactionId()
            );

            if ($cashInTransactionEntity->isSuccessful()) {
                $result = $this
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
                    'status' => $cashInTransactionEntity->getStatus()
                ]
            ]
        ]);
    }

    public function callback(
        Request $request
    )
    {
        $this->cashInTransactionService
            ->addTransactionEvent(
                '5fa7d7eecd12e8702c35ce13',
                'requestToPay.approved',
                $request->all()
            );

    }
}
