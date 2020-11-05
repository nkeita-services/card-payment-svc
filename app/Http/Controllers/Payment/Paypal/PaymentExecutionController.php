<?php


namespace App\Http\Controllers\Payment\Paypal;

use App\Rules\CashIn\CashInOriginatorAccountRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Laravel\Lumen\Http\Redirector;
use Payment\Account\Service\AccountServiceInterface;
use Payment\CashIn\Transaction\CashInTransactionEntity;
use Payment\Paypal\PaymentExecution\Entity\PaymentExecution;
use Payment\Paypal\PaymentExecution\Service\PaymentExecutionServiceInterface;
use Illuminate\Support\Facades\Validator;
use Payment\Paypal\PaymentExecution\Service\Exception\PaymentExecutionException;
use App\Http\Controllers\Controller;


class PaymentExecutionController extends Controller
{
    /**
     *
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * @var PaymentExecutionServiceInterface
     */
    private $paymentExecutionService;

    /**
     * PaymentIntentController constructor.
     * @param AccountServiceInterface $accountService
     * @param PaymentExecutionServiceInterface $paymentExecutionService
     */
    public function __construct(
        AccountServiceInterface $accountService,
        PaymentExecutionServiceInterface $paymentExecutionService
    )
    {
        $this->accountService = $accountService;
        $this->paymentExecutionService = $paymentExecutionService;
    }

    /**
     * @param string $accountId
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function createOrder(
        string $accountId,
        Request $request
    )
    {
        $validator = Validator::make(
            array_merge(
                $request->all(),
                [
                    'originator'=> array_merge(
                        $request->json('originator'),
                        ['accountId' => $accountId]
                    )
                ]
            ),
            [
                'amount' => ['required', 'numeric'],
                'originator' => ['required', 'array', app(CashInOriginatorAccountRule::class)],
                'description' => ['required', 'string'],
                'currency' => ['required', 'string']
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 0,
                    'StatusDescription' => $validator->errors()
                ]
            );
        }

        if($request->has('applicationContext'))
        {
            $successUrl = $request->get('applicationContext')['successUrl'];
            $cancelOrFailUrl = $request->get('applicationContext')['cancelOrFailUrl'];
        }

        $paymentExecution = new PaymentExecution(
            $request->get('amount'),
            $request->get('currency'),
            $accountId,
            isset($successUrl)? $successUrl : null,
            isset($cancelOrFailUrl)? $cancelOrFailUrl : null
        );

        try {
            $transaction = $this->paymentExecutionService->createOrder(
                new CashInTransactionEntity(
                    'PAYPAL',
                    null,
                    $request->get('amount'),
                    $request->get('currency'),
                    $request->get('description'),
                    $accountId,
                    [
                        'originatorType' => "User",
                        'originatorId' => $request->get('userId')
                    ],
                    'pending',
                    time()
                ),
                $paymentExecution
            );
        } catch (PaymentExecutionException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 0,
                    'StatusDescription' => $e->getMessage()
                ]
            );
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'CashIn' => [
                    'transactionId' => $transaction->getTransactionId(),
                    'amount' => $transaction->getAmount(),
                    'status' => $transaction->getStatus(),
                    'extras' => $transaction->getExtras()
                ]
            ]
        ]);

       /* return redirect(
            $transaction->getExtras()
            ['approveUrl']
        );*/
    }


    /**
     * @param float $amount
     * @param string $currency
     * @param string $accountId
     * @param string $userId
     * @return View
     */
    public function form(
        float $amount,
        string $currency,
        string $accountId,
        string $userId
    )
    {
        return view(
            'paypal.checkout',
           [
              'amount' => $amount,
              'currency' => $currency,
              'accountId' => $accountId,
              'userId' => $userId,
              'description' => 'Top Up with Paypal',
          ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function webHook(Request $request)
    {
       $validator = Validator::make(
            $request->all(),
            $this->paymentExecutionService->rules()
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 0,
                    'StatusDescription' => $validator->errors()
                ]
            );
        }

        $event = $request->all();

        $transaction = $this
            ->paymentExecutionService
            ->storeEvent(
                $event['resource']['id'],
                $event['event_type'],
                $event['resource']
            );


        if ('CHECKOUT.ORDER.APPROVED' ==  $event['event_type']) {
            $this->accountService->topUpFromCashInTransaction(
                $transaction
            );
        }

        return response()->json(
            [
                'ressource' => $event['resource'],
            ], 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function success(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'token' => ['required', 'string'],
                'PayerID' => ['required', 'string'],
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 0,
                    'StatusDescription' => $validator->errors()
                ]
            );
        }
        try {

            $transaction = $this->paymentExecutionService->captureOrder(
                $request->get('token')
            );

            if (!is_null( $transaction->getExtras()['successUrl']))
            {
                return redirect(
                    sprintf('%s?orderId=%s&paymentId=%s&transactionId=%s',
                        $transaction->getExtras()['successUrl'],
                        $transaction->getExtras()['orderId'],
                        $transaction->getExtras()['paymentId'],
                        $transaction->getTransactionId()
                    )
                );
            }

            return view('paypal.success');
        } catch (PaymentExecutionException $e) {
            return view('paypal.cancel',
                ['errors' => $e->getMessage()]
            );
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function cancel(Request $request)
    {
        $transaction = $this->paymentExecutionService
            ->getTransactionByOrderId(
            $request->get('token')
        );

        if (!is_null( $transaction->getExtras()['cancelUrl']))
        {
            return redirect(
                sprintf('%s?orderId=%s',
                    $transaction->getExtras()['cancelUrl'],
                    $request->get('token')
                )
            );
        }

        return view('paypal.cancel');
    }

}
