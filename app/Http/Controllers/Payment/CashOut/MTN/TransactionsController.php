<?php


namespace App\Http\Controllers\Payment\CashOut\MTN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Payment\Account\Collection\AccountCollection;
use Payment\Account\Service\AccountService;
use Payment\Account\Service\AccountServiceInterface;
use Payment\CashOut\Transaction\Service\CashOutTransactionService;
use Payment\CashOut\Transaction\Service\CashOutTransactionServiceInterface;
use Payment\MTN\Remittance\Service\MTNRemittanceService;
use Payment\MTN\Remittance\Service\MTNRemittanceServiceInterface;
use Exception;

class TransactionsController extends Controller
{

    /**
     * @var MTNRemittanceServiceInterface
     */
    private $remittanceService;

    /**
     * @var CashOutTransactionServiceInterface
     */
    private $cashOutTransactionService;

    /**
     *
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * CashOutController constructor.
     * @param MTNRemittanceService $remittanceService
     * @param CashOutTransactionService $cashOutTransactionService
     * @param AccountService $accountService
     */
    public function __construct(
        MTNRemittanceService $remittanceService,
        CashOutTransactionService $cashOutTransactionService,
        AccountService $accountService
    )
    {
        $this->remittanceService = $remittanceService;
        $this->cashOutTransactionService = $cashOutTransactionService;
        $this->accountService = $accountService;
    }


    public function fetch(string $transactionId, Request $request)
    {
        try {
            $cashOutTransactionEntity = $this->remittanceService->transferStatus(
                $transactionId
            );
        } catch (Exception $exception) {
            return response()->json([
                'status' => 'failure',
                'statusCode' => 10001,
                'statusDescription' => $exception->getMessage()
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'CashOut' => [
                    'transactionId' => $cashOutTransactionEntity->getTransactionId(),
                    'status'=> $cashOutTransactionEntity->getStatus()
                ]
            ]
        ]);
    }

    public function updateWalletAccounts()
    {
        $transactions = $this->cashOutTransactionService
            ->fetchPendingTransactionFor(
                'MTN'
            );

        $accounts = [];
        foreach ($transactions as $transaction){
            $cashOutTransactionEntity = $this->remittanceService->transferStatus(
                $transaction->getTransactionId()
            );

            if($cashOutTransactionEntity->isSuccessful()){
                $this
                    ->accountService
                    ->debitFromCashOutTransaction(
                        $cashOutTransactionEntity
                    );

                $accounts[] = $this->accountService
                    ->fetchWithUserIdAndAccountId(
                        $cashOutTransactionEntity->getOriginatorId(),
                        $cashOutTransactionEntity->getAccountId()
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
}
