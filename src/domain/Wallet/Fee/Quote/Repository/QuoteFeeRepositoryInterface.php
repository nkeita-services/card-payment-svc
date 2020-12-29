<?php


namespace Payment\Wallet\Fee\Quote\Repository;


use Payment\Wallet\Fee\Quote\Entity\QuoteRequestEntityInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteFeeEntityInterface;

interface QuoteFeeRepositoryInterface
{
    /**
     * @param QuoteRequestEntityInterface $quoteRequestEntity
     * @return QuoteFeeEntityInterface
     */
    public function getQuote(
        QuoteRequestEntityInterface $quoteRequestEntity
    ) : QuoteFeeEntityInterface;
}
