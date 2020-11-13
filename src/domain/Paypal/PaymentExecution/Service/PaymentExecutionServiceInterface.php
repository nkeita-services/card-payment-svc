<?php


namespace Payment\Paypal\PaymentExecution\Service;


use Payment\CashIn\Transaction\CashInTransactionEntity;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\Paypal\PaymentExecution\Entity\PaymentExecutionInterface;


interface PaymentExecutionServiceInterface
{
    /**
     * @param CashInTransactionEntity $transactionEntity
     * @param PaymentExecutionInterface $paymentExecution
     * @return CashInTransactionEntityInterface
     */
    public function createOrder(
        CashInTransactionEntity $transactionEntity,
        PaymentExecutionInterface $paymentExecution
    ): CashInTransactionEntityInterface;

    /**
     * @param string $orderId
     * @return CashInTransactionEntityInterface
     */
    public function captureOrder(
        string $orderId
    ) : CashInTransactionEntityInterface ;

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
    ) : CashInTransactionEntityInterface ;

    /**
     * @return array
     */
    public function rules() : array ;

    /**
     * @param string $orderId
     * @return CashInTransactionEntityInterface
     */
    public function getTransactionByOrderId(
        string $orderId
    ) : CashInTransactionEntityInterface;
}
