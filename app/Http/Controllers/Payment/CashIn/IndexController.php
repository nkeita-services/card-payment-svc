<?php


namespace App\Http\Controllers\Payment\CashIn;

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


    public function create(string $accountId, Request $request)
    {
        try {
            $this->collectionService->requestToPay(
                $accountId,
                $request->json('amount')
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
                'CashIn' => 'successful'
            ]
        ]);
    }
}
