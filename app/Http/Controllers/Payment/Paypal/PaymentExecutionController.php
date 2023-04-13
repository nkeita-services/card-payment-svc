<?php


namespace App\Http\Controllers\Payment\Paypal;

use App\Rules\CashIn\CashInOriginatorAccountRule;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Laravel\Lumen\Http\Redirector;
use Payment\Account\Service\AccountServiceInterface;
use Payment\CashIn\Transaction\CashInTransactionEntity;
use Payment\Paypal\PaymentExecution\Entity\PaymentExecution;
use Payment\Paypal\PaymentExecution\Service\PaymentExecutionServiceInterface;
use Illuminate\Support\Facades\Validator;
use Payment\Paypal\PaymentExecution\Service\Exception\PaymentExecutionException;
use App\Http\Controllers\Controller;
use Payment\Wallet\Fee\Quote\Service\QuoteFeeServiceInterface;


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
                        $request->get('originator'),
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
            $successUrl = $request->json()->get('applicationContext')['successUrl'];
            $cancelOrFailUrl = $request->json()->get('applicationContext')['cancelOrFailUrl'];
        }

        $paymentExecution = new PaymentExecution(
            $request->json()->get('amount'),
            $request->json()->get('currency'),
            $accountId,
            $successUrl ? $successUrl : "https://wallet-payment-svc-x6fr3lwlgq-nw.a.run.app/v1/paypal/payments/sucess",
            $cancelOrFailUrl? : "https://wallet-payment-svc-x6fr3lwlgq-nw.a.run.app/v1/paypal/payments/cancel"
        );

        try {
            $transaction = $this->paymentExecutionService->createOrder(
                new CashInTransactionEntity(
                    'PAYPAL',
                    null,
                    $request->json()->get('amount'),
                    $request->json()->get('currency'),
                    $request->json()->get('description'),
                    $accountId,
                    $request->json()->get('regions'),
                    [
                        'originatorType' => "User",
                        'originatorId' => $request->json()->get('originator')['originatorId']
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
        if ('CHECKOUT.ORDER.APPROVED' ==  $event['event_type']) {
            $transaction = $this
                ->paymentExecutionService
                ->storeEvent(
                    $event['resource']['id'],
                    $event['event_type'],
                    $event['resource']
                );

           /* $this->accountService->topUpFromCashInTransaction(
                $transaction
            );*/
        }

        return response()->json(
            [
                'status' => 'success',
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
                'orderId' => ['required', 'string'],
                'paymentId' => ['required', 'string'],
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
                $request->get('orderId')
            );

            $this->accountService->topUpFromCashInTransaction(
                $transaction
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
