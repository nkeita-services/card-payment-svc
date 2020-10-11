<?php


namespace App\Http\Controllers\Payment\CashIn\MTN;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Payment\MTN\Collection\Service\CollectionService;
use Payment\MTN\Collection\Service\CollectionServiceInterface;
use Payment\MTN\Collection\Service\Exception\RequestToPayException;

class IndexController extends Controller
{

    /**
     * @var CollectionServiceInterface
     */
    private $collectionService;

    /**
     * IndexController constructor.
     * @param CollectionServiceInterface $collectionService
     */
    public function __construct(CollectionService $collectionService)
    {
        $this->collectionService = $collectionService;
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
                $request->json('originator')
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
