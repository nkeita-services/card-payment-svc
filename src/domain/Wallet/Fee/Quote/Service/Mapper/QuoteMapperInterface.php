<?php


namespace Payment\Wallet\Fee\Quote\Service\Mapper;


use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteRequestEntityInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteFeeEntityInterface;
use Payment\Wallet\Fee\Quote\Service\QuoteFeeServiceInterface;

interface QuoteMapperInterface
{
    /**
     * @param CashInTransactionEntityInterface $transaction
     * @return QuoteRequestEntityInterface
     */
    public function createQuotePayloadFromTransaction(
        CashInTransactionEntityInterface $transaction
    ):QuoteRequestEntityInterface;

    /**
     * @param CashOutTransactionEntityInterface $transaction
     * @return QuoteRequestEntityInterface
     */
    public function createQuotePayloadFromCashOut(
        CashOutTransactionEntityInterface $transaction
    ):QuoteRequestEntityInterface;
}
