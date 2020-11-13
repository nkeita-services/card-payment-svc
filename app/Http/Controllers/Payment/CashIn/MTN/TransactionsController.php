<?php

namespace App\Http\Controllers\Payment\CashIn\MTN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Payment\Account\Collection\AccountCollection;
use Payment\Account\Service\AccountServiceInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionService;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;
use Payment\CashIn\Transaction\Service\CashOutTransactionServiceInterface;
use Payment\MTN\Collection\Service\CollectionService;
use Payment\MTN\Collection\Service\CollectionServiceInterface;
use Payment\MTN\Collection\Service\Exception\RequestToPayException;

class TransactionsController extends Controller
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
     * TransactionsController constructor.
     * @param CollectionService $collectionService
     * @param CashInTransactionService $cashInTransactionService
     * @param AccountServiceInterface $accountService
     */
    public function __construct(
        CollectionService $collectionService,
        CashInTransactionService $cashInTransactionService,
        AccountServiceInterface $accountService
    ){
        $this->collectionService = $collectionService;
        $this->cashInTransactionService = $cashInTransactionService;
        $this->accountService = $accountService;
    }


    public function fetch(string $transactionId, Request $request)
    {
        try {
            $cashInTransactionEntity = $this->collectionService->requestToPayStatus(
                $transactionId
            );
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

    public function updateWalletAccounts()
    {
        $transactions = $this->cashInTransactionService
            ->fetchPendingTransactionFor(
                'MTN'
            );


        $accounts = [];
        foreach ($transactions as $transaction){
            $cashInTransactionEntity = $this->collectionService->requestToPayStatus(
                $transaction->getTransactionId()
            );

            if($cashInTransactionEntity->isSuccessful()){
                $this
                    ->accountService
                    ->topUpFromCashInTransaction(
                        $cashInTransactionEntity
                    );

                $accounts[] = $this->accountService
                    ->fetchWithUserIdAndAccountId(
                        $cashInTransactionEntity->getOriginatorId(),
                        $cashInTransactionEntity->getAccountId()
                    )->toArray();
            }
        }

        $accountCollection = AccountCollection::fromArray(
            $accounts
        );

        return response()->json([
            'status' => 'success',
            'data' => [
                'WalletAccounts' => $accountCollection->toArray()
            ]
        ]);
    }

    public function callback(
        Request $request
    ){
        $this->cashInTransactionService
            ->addTransactionEvent(
                '5fa7d7eecd12e8702c35ce13',
                'requestToPay.approved',
                $request->all()
            );

    }
}
