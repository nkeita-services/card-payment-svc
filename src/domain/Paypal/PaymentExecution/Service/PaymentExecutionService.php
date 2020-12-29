<?php


namespace Payment\Paypal\PaymentExecution\Service;

use Payment\CashIn\Transaction\CashInTransactionEntity;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;
use Payment\Paypal\PaymentExecution\Entity\PaymentExecutionInterface;
use Payment\Wallet\Fee\Quote\Service\QuoteFeeServiceInterface;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Payment\Paypal\PaymentExecution\Service\Exception\PaymentExecutionException;
use PayPalHttp\HttpException;
use Ramsey\Uuid\Uuid;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;

class PaymentExecutionService implements PaymentExecutionServiceInterface
{
    /**
     * @var CashInTransactionServiceInterface
     */
    private $cashInTransactionService;

    /**
     * @var PayPalHttpClient
     */
    private $httpClient;

    /**
     * @var OrdersCreateRequest
     */
    private $paymentExecutionRequest;

    /**
     * @var QuoteFeeServiceInterface
     */
    private $quoteFeeService;

    /**
     * PaymentIntentService constructor.
     * @param CashInTransactionServiceInterface $cashInTransactionService
     * @param PayPalHttpClient $httpClient
     * @param OrdersCreateRequest $paymentExecutionRequest
     * @param QuoteFeeServiceInterface $quoteFeeService
     */
    public function __construct(
        CashInTransactionServiceInterface $cashInTransactionService,
        PayPalHttpClient $httpClient,
        OrdersCreateRequest $paymentExecutionRequest,
        QuoteFeeServiceInterface $quoteFeeService
    )
    {
        $this->cashInTransactionService = $cashInTransactionService;
        $this->httpClient = $httpClient;
        $this->paymentExecutionRequest = $paymentExecutionRequest;
        $this->quoteFeeService = $quoteFeeService;
    }

    /**
     * @param CashInTransactionEntity $transactionEntity
     * @param PaymentExecutionInterface $paymentExecution
     * @return CashInTransactionEntityInterface
     */
    public function createOrder(
        CashInTransactionEntity $transactionEntity,
        PaymentExecutionInterface $paymentExecution
    ): CashInTransactionEntityInterface
    {
        $transaction = $this
            ->cashInTransactionService
            ->store($transactionEntity);

        $fees = $this->quoteFeeService->getQuotes($transaction);
        $this->cashInTransactionService
            ->addTransactionFees(
                $transaction->getTransactionId(),
                $fees->toArray()
            );

        $this->paymentExecutionRequest
            ->prefer('return=representation');
        $this->paymentExecutionRequest
            ->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => Uuid::uuid4()->toString(),
                "amount" => [
                    "value"         => floatval($transactionEntity->getAmount()/100),
                    "currency_code" => $transactionEntity->getCurrency()
                ]
            ]],
            "application_context" => [
                "cancel_url" => route('cancel'),
                "return_url" => route('return')
            ]
        ];

        try {

            $paymentExecute = $this
                ->httpClient
                ->execute($this->paymentExecutionRequest);

            foreach($paymentExecute->result->links as $link)
            {
                if ($link->rel === 'approve')
                {
                    $approveUrl = $link->href;
                }
            }

            $this
                ->cashInTransactionService
                ->addAdditionalInfo(
                    $transaction->getTransactionId(),
                    [
                        'orderId' => $paymentExecute->result->id,
                        'approveUrl' =>  $approveUrl,
                        'successUrl' => $paymentExecution->getReturnUrl(),
                        'cancelUrl'  => $paymentExecution->getCancelUrl()
                    ]
                );
            return $this
                ->cashInTransactionService
                ->fetchWithTransactionId(
                    $transaction->getTransactionId()
                );
        } catch (HttpException $e) {
            throw new PaymentExecutionException(
                $e->getMessage()
            );
        }
    }

    public function captureOrder(string $orderId) : CashInTransactionEntityInterface
    {
        $ordersCaptureRequest = new OrdersCaptureRequest($orderId);
        $ordersCaptureRequest->prefer('return=representation');

        try {
            $response = $this
                ->httpClient->execute($ordersCaptureRequest);

            $transaction = $this
                ->cashInTransactionService
                ->lookUpExtraInformationFor(
                    [
                        'orderId' => $orderId
                    ]
                );

            $this
                ->cashInTransactionService
                ->addAdditionalInfo(
                    $transaction->getTransactionId(),
                    [
                        'orderId' => $response->result->id,
                        'status' => $response->result->status,
                        'paymentId' => $response->result->payer->payer_id,
                        'successUrl' => $transaction->getExtras()['successUrl'],
                        'cancelUrl' => $transaction->getExtras()['cancelUrl'],
                        'approveUrl' => $transaction->getExtras()['approveUrl']
                    ]
                );

            return $this
                ->cashInTransactionService
                ->fetchWithTransactionId(
                    $transaction->getTransactionId()
                );

        } catch (HttpException $e) {
            throw new PaymentExecutionException(
                $e->getMessage()
            );
        }
    }

    /**
     * @param string $orderId
     * @param string $eventType
     * @param array $event
     * @return CashInTransactionEntityInterface
     */
    public function storeEvent(
        string $orderId,
        string $eventType,
        array $event
    ):CashInTransactionEntityInterface
    {
        $transaction = $this
            ->cashInTransactionService
            ->lookUpExtraInformationFor(
                [
                    'orderId' => $orderId
                ]
            );

        $this->cashInTransactionService
            ->addTransactionEvent(
                $transaction->getTransactionId(),
                $eventType,
                $event
            );

        return $transaction;
    }

    /**
     * @return array
     */
    public function rules() : array
    {
        return [
            'id' => ['required', 'string'],
            'create_time' => ['required', 'string'],
            'resource_type' => ['required', 'string'],
            'event_type' => ['required', 'string'],
            'summary' => ['required', 'string'],
            'resource' => ['required', 'array'],
        ];
    }

    /**
     * @param string $orderId
     * @return CashInTransactionEntityInterface
     */
    public function getTransactionByOrderId(
        string $orderId
    ) : CashInTransactionEntityInterface
    {
        return $this
            ->cashInTransactionService
            ->lookUpExtraInformationFor(
                [
                    'orderId' => $orderId
                ]
            );
    }

}
