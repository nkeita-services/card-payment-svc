<?php


namespace Payment\AliPayWechatPay\PaymentOrder\Service;


use App\Rules\CashIn\CashInOriginatorAccountRule;
use Payment\AliPayWechatPay\PaymentOrder\Entity\PaymentOrderInterface;
use Payment\AliPayWechatPay\PaymentOrder\Repository\PaymentOrderRepositoryInterface;
use Payment\CashIn\Transaction\CashInTransactionEntity;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;
use Payment\Wallet\Fee\Quote\Service\Exception\QuoteNotFoundServiceException;
use Payment\Wallet\Fee\Quote\Service\QuoteFeeServiceInterface;
use Payment\AliPayWechatPay\PaymentOrder\Service\Exception\PaymentOrderException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PaymentOrderService implements PaymentOrderServiceInterface
{

    /**
     * @var PaymentOrderRepositoryInterface
     */
    private $paymentOrderRepository;

    /**
     * @var CashInTransactionServiceInterface
     */
    private $cashInTransactionService;

    /**
     * @var QuoteFeeServiceInterface
     */
    private $quoteFeeService;

    /**
     * PaymentOrderService constructor.
     * @param PaymentOrderRepositoryInterface $paymentOrderRepository
     * @param CashInTransactionServiceInterface $cashInTransactionService
     * @param QuoteFeeServiceInterface $quoteFeeService
     */
    public function __construct(
        PaymentOrderRepositoryInterface $paymentOrderRepository,
        CashInTransactionServiceInterface $cashInTransactionService,
        QuoteFeeServiceInterface $quoteFeeService
    )
    {
        $this->paymentOrderRepository = $paymentOrderRepository;
        $this->cashInTransactionService = $cashInTransactionService;
        $this->quoteFeeService = $quoteFeeService;
    }

    /**
     * @param CashInTransactionEntity $transactionEntity
     * @param PaymentOrderInterface $paymentOrder
     * @return CashInTransactionEntityInterface
     */
    public function createPaymentOrder(
        CashInTransactionEntity $transactionEntity,
        PaymentOrderInterface $paymentOrder
    ): CashInTransactionEntityInterface
    {
        $transaction = $this
            ->cashInTransactionService
            ->store($transactionEntity);

        try {
            $fees = $this->quoteFeeService->getQuotes($transaction);
            $fees->setEventType(
                CashInTransactionEntityInterface::FEES_EVENT
            );
            $fees->setTransactionId(
                $transaction
                    ->getTransactionId()
            );
            $this->cashInTransactionService
                ->addTransactionFees(
                    $transaction->getTransactionId(),
                    $fees->toArray()
                );

        }catch (QuoteNotFoundServiceException $e) {}


        $paymentOrderResult = $this
            ->paymentOrderRepository
            ->createPaymentOrder
            (
                $paymentOrder
            );

        if (isset(
            $paymentOrderResult['result_code']) &&
           isset( $paymentOrderResult['status']) &&
            $paymentOrderResult['result_code'] == 0 &&
            $paymentOrderResult['status'] == 0
        ) {
            try {
                $this
                    ->cashInTransactionService
                    ->addAdditionalInfo(
                        $transaction->getTransactionId(),
                        $paymentOrderResult
                    );

                return $this
                    ->cashInTransactionService
                    ->fetchWithTransactionId(
                        $transaction->getTransactionId()
                    );

            } catch (HttpException $e) {
                throw new PaymentOrderException(
                    $e->getMessage()
                );
            }
        } else {
            throw new PaymentOrderException(
                json_encode(
                    $paymentOrderResult,
                    JSON_PRETTY_PRINT
                )
            );
        }
    }

    /**
     * @param string $nonceStr
     * @param string $eventType
     * @param array $event
     * @return CashInTransactionEntityInterface
     */
     public function storeEvent(
         string $nonceStr,
         string $eventType,
         array $event
     ) : CashInTransactionEntityInterface
     {
         $transaction = $this
             ->cashInTransactionService
             ->lookUpExtraInformationFor(
                 [
                     'nonce_str' => $nonceStr
                 ]
             );

         $event['eventType'] = $eventType;
         $event['transactionId'] = $transaction->getTransactionId();

         $this->cashInTransactionService
             ->addTransactionEvent(
                 $transaction->getTransactionId(),
                 $eventType,
                 $event
             );

         return $transaction;
     }


    /**
     * @param string $nonceStr
     * @return CashInTransactionEntityInterface
     */
    public function getTransactionByNonceStr(
        string $nonceStr
    ) : CashInTransactionEntityInterface
    {
        return $this
            ->cashInTransactionService
            ->lookUpExtraInformationFor(
                [
                    'nonce_str' => $nonceStr
                ]
            );
    }

    public function rules(): array
    {
        return [
            'amount' => ['required', 'numeric'],
            'originator' => ['required', 'array', app(CashInOriginatorAccountRule::class)],
            'description' => ['required', 'string'],
            'currency' => ['required', 'string'],
            'body' => ['required', 'string'],
            'mch_create_ip' => ['required', 'string'],
            'notify_url' => ['required', 'string'],
        ];
    }
}
