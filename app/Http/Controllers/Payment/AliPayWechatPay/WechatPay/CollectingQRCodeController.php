<?php


namespace App\Http\Controllers\Payment\AliPayWechatPay\Wechatpay;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Payment\Account\Service\AccountServiceInterface;
use Payment\AliPayWechatPay\PaymentOrder\Entity\PaymentOrder;
use Payment\AliPayWechatPay\PaymentOrder\Entity\PaymentOrderInterface;
use Payment\AliPayWechatPay\PaymentOrder\Service\Exception\PaymentOrderException;
use Payment\AliPayWechatPay\PaymentOrder\Service\PaymentOrderServiceInterface;
use Payment\CashIn\Transaction\CashInTransactionEntity;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;

class CollectingQRCodeController extends Controller
{
    /**
     *
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * @var PaymentOrderServiceInterface
     */
    private $collectingQRCodeService;

    /**
     * CreatePaymentController constructor.
     * @param AccountServiceInterface $accountService
     * @param PaymentOrderServiceInterface $collectingQRCodeService
     */
    public function __construct(
        AccountServiceInterface $accountService,
        PaymentOrderServiceInterface $collectingQRCodeService
    )
    {
        $this->accountService = $accountService;
        $this->collectingQRCodeService = $collectingQRCodeService;
    }
    public function collectingQRCode(
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
            $this->collectingQRCodeService->rules()
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
            $transaction = $this->collectingQRCodeService->createPaymentOrder(
                new CashInTransactionEntity(
                    CashInTransactionEntityInterface::TYPE_WECHATPAY,
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
                new PaymentOrder(
                    PaymentOrderInterface::WECHATPAY_SERVICE,
                    $request->json()->get('mch_id'),
                    $request->json()->get('body'),
                    $request->json()->get('amount'),
                    $request->json()->get('mch_create_ip'),
                    $request->json()->get('notify_url'),
                    $request->json()->get('key')
                )
            );
        } catch (PaymentOrderException $e) {
            return response()->json(
                [
                    'status' => 'error',
                    'StatusCode' => 0,
                    'StatusDescription' => json_decode($e->getMessage())
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

    }
}
