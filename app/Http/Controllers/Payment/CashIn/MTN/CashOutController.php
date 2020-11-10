<?php


namespace App\Http\Controllers\Payment\CashIn\MTN;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Payment\CashIn\MTN\Mapper\CashOutTransactionMapper;
use App\Http\Controllers\Payment\CashIn\MTN\Mapper\CashOutTransactionMapperInterface;
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
    private $cashInTransactionService;

    /**
     *
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * CashOutController constructor.
     * @param MTNRemittanceService $remittanceService
     * @param CashOutTransactionService $cashInTransactionService
     * @param AccountService $accountService
     */
    public function __construct(
        MTNRemittanceService $remittanceService,
        CashOutTransactionService $cashInTransactionService,
        AccountService $accountService
    )
    {
        $this->remittanceService = $remittanceService;
        $this->cashInTransactionService = $cashInTransactionService;
        $this->accountService = $accountService;
    }


    public function create(string $accountId, Request $request)
    {

        try {
            $cashInTransactionEntity = $this
                ->remittanceService
                ->transferFromCashOutRequest(
                    CashOutTransactionMapper::createCashOutTransactionFromHttpRequest(
                        $accountId,
                        $request
                    )
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
}
