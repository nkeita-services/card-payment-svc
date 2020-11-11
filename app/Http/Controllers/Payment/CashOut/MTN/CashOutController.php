<?php


namespace App\Http\Controllers\Payment\CashOut\MTN;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Payment\CashOut\MTN\Mapper\CashOutTransactionMapper;
use App\Http\Controllers\Payment\CashOut\MTN\Mapper\CashOutTransactionMapperInterface;
use Illuminate\Http\Request;
use Payment\Account\Service\AccountService;
use Payment\Account\Service\AccountServiceInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionService;
use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;
use Payment\CashOut\Transaction\Service\CashOutTransactionService;
use Payment\CashOut\Transaction\Service\CashOutTransactionServiceInterface;
use Payment\MTN\Collection\Service\CollectionService;
use Payment\MTN\Collection\Service\CollectionServiceInterface;
use Payment\MTN\Collection\Service\Exception\RequestToPayException;
use Payment\MTN\Remittance\Service\MTNRemittanceService;
use Payment\MTN\Remittance\Service\MTNRemittanceServiceInterface;

class CashOutController extends Controller
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


    public function create(string $accountId, Request $request)
    {

        try {
            $cashOutTransactionEntity = $this
                ->remittanceService
                ->transferFromCashOutRequest(
                    CashOutTransactionMapper::createCashOutTransactionFromHttpRequest(
                        $accountId,
                        $request
                    )
                );

            $cashOutTransactionEntity = $this->remittanceService->transferStatus(
                $cashOutTransactionEntity->getTransactionId()
            );

            if($cashOutTransactionEntity->isSuccessful()){
                $this
                    ->accountService
                    ->debitFromCashOutTransaction(
                        $cashOutTransactionEntity
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
                    'transactionId' => $cashOutTransactionEntity->getTransactionId(),
                    'status'=> $cashOutTransactionEntity->getStatus()
                ]
            ]
        ]);
    }

}
