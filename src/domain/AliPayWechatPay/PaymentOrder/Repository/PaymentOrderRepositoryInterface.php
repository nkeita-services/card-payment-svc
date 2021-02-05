<?php


namespace Payment\AliPayWechatPay\PaymentOrder\Repository;


use Payment\AliPayWechatPay\PaymentOrder\Entity\PaymentOrderInterface;

interface PaymentOrderRepositoryInterface
{
    /**
     * @param PaymentOrderInterface $paymentOrderd
     * @return array
     */
    public function createPaymentOrder(PaymentOrderInterface $paymentOrderd) : array;
}
