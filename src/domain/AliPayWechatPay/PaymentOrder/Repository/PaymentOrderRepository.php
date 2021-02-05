<?php


namespace Payment\AliPayWechatPay\PaymentOrder\Repository;


use Infrastructure\Api\Soap\Client\AliPayWechatPay\PaymentOrderApiClientInterface;
use Payment\AliPayWechatPay\PaymentOrder\Entity\PaymentOrderInterface;

class PaymentOrderRepository implements PaymentOrderRepositoryInterface
{

    /**
     * @var PaymentOrderApiClientInterface
     */
    private $paymentOrderApiClient;

    /**
     * PaymentOrderRepository constructor.
     * @param PaymentOrderApiClientInterface $paymentOrderApiClient
     */
    public function __construct(
        PaymentOrderApiClientInterface $paymentOrderApiClient
    )
    {
        $this->paymentOrderApiClient = $paymentOrderApiClient;
    }


    /**
     * @param PaymentOrderInterface $paymentOrder
     * @return array
     */
    public function createPaymentOrder(PaymentOrderInterface $paymentOrder) : array
    {
        return $this->paymentOrderApiClient
            ->createPaymentOrder(
                $paymentOrder
            );
    }
}
