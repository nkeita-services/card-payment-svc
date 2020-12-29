<?php


namespace Payment\Wallet\Fee\Quote\Service;


use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteRequestEntityInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteFeeEntityInterface;

interface QuoteFeeServiceInterface
{
    /**
     * @param QuoteRequestEntityInterface $quoteRequestEntity
     * @return QuoteFeeEntityInterface
     */
    public function getQuote(
        QuoteRequestEntityInterface $quoteRequestEntity
    ) : QuoteFeeEntityInterface;

    /**
     * @param CashInTransactionEntityInterface $transaction
     * @return QuoteFeeEntityInterface
     */
    public function getQuotes(
        CashInTransactionEntityInterface $transaction
    ) : QuoteFeeEntityInterface;

    /**
     * @param CashOutTransactionEntityInterface $transaction
     * @return QuoteFeeEntityInterface
     */
    public function getCashOutQuotes(
        CashOutTransactionEntityInterface $transaction
    ) : QuoteFeeEntityInterface;
}
