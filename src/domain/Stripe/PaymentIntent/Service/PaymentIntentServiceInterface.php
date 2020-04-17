<?php

namespace Payment\Stripe\PaymentIntent\Service;


use Payment\CashIn\Transaction\CashInTransactionEntity;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\Stripe\PaymentIntent\Entity\PaymentIntentInterface;

interface PaymentIntentServiceInterface{

    /**
     * @param CashInTransactionEntity $transactionEntity
     * @return CashInTransactionEntityInterface
     */
    public function create(
        CashInTransactionEntity $transactionEntity
    ): CashInTransactionEntityInterface ;


    /**
     * @param string $clientSecret
     * @param string $eventType
     * @param array $event
     * @return CashInTransactionEntityInterface
     */
    public function storeEvent(
        string $clientSecret,
        string $eventType,
        array $event
    ):CashInTransactionEntityInterface;

    /**
     * @param string $clientSecret
     * @return PaymentIntentInterface
     */
    public function fromClientSecret(
        string $clientSecret
    ):PaymentIntentInterface;
}
