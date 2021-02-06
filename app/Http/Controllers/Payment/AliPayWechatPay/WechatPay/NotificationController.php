<?php


namespace App\Http\Controllers\Payment\AliPayWechatPay\Wechatpay;


use App\Http\Controllers\Controller;
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


    public function notify(Request $request)
    {
        dd($request->all());
    }

}
