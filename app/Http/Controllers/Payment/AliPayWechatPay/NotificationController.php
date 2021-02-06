<?php


namespace App\Http\Controllers\Payment\AliPayWechatPay;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Payment\Account\Service\AccountServiceInterface;
use Payment\AliPayWechatPay\PaymentOrder\Service\PaymentOrderServiceInterface;

class NotificationController extends Controller
{
    /**
     *
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * @var PaymentOrderServiceInterface
     */
    private $paymentOrderService;

    /**
     * CreatePaymentController constructor.
     * @param AccountServiceInterface $accountService
     * @param PaymentOrderServiceInterface $paymentOrderService
     */
    public function __construct(
        AccountServiceInterface $accountService,
        PaymentOrderServiceInterface $paymentOrderService
    )
    {
        $this->accountService = $accountService;
        $this->paymentOrderService = $paymentOrderService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function notify(Request $request)
    {
        $dataNotification = $request->all();
        if (
            isset($dataNotification['status']) &&
            isset($dataNotification['result_code']) &&
            $dataNotification['status'] == 0 &&
            $dataNotification['result_code'] == 0
        ) {

            $transaction = $this
                ->paymentOrderService
                ->storeEvent(
                    $dataNotification['nonce_str'],
                    "TopUp",
                    $dataNotification
                );

            $this->accountService
                ->topUpFromCashInTransaction(
                    $transaction
                );

        }
        return response()->json(
            [
                'status' => 'success',
            ], 200);
    }
}
