<?php


namespace Infrastructure\Api\Soap\Client\AliPayWechatPay;


use Payment\AliPayWechatPay\PaymentOrder\Entity\PaymentOrderInterface;

interface PaymentOrderApiClientInterface
{

    /**
     * @param PaymentOrderInterface $paymentOrder
     * @return array
     */
    public function createPaymentOrder(
        PaymentOrderInterface $paymentOrder
    ): array;
}
