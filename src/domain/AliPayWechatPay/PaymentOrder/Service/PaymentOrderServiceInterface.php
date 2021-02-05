<?php


namespace Payment\AliPayWechatPay\PaymentOrder\Service;


use Payment\AliPayWechatPay\PaymentOrder\Entity\PaymentOrderInterface;
use Payment\CashIn\Transaction\CashInTransactionEntity;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;

interface PaymentOrderServiceInterface
{
    /**
     * @param CashInTransactionEntity $transactionEntity
     * @param PaymentOrderInterface $paymentOrder
     * @return CashInTransactionEntityInterface
     */
    public function createPaymentOrder(
        CashInTransactionEntity $transactionEntity,
        PaymentOrderInterface $paymentOrder
    ): CashInTransactionEntityInterface;

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
    ) : CashInTransactionEntityInterface;

    /**
     * @param string $nonceStr
     * @return CashInTransactionEntityInterface
     */
    public function getTransactionByNonceStr(
        string $nonceStr
    ) : CashInTransactionEntityInterface;

    /**
     * @return array
     */
    public function rules() : array;

}
