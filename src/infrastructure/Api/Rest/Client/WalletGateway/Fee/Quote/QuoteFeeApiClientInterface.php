<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote;


use Payment\Wallet\Fee\Quote\Entity\QuoteFeeEntityInterface;

interface QuoteFeeApiClientInterface
{
    /**
     * @param array $quoteFeePayload
     * @return QuoteFeeEntityInterface
     */
    public function getQuote(
        array $quoteFeePayload
    ): QuoteFeeEntityInterface;
}
