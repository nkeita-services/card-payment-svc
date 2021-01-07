<?php


namespace Payment\Wallet\Fee\Quote\Repository;


use Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote\Exception\QuoteFeeNotFoundException;
use Infrastructure\Api\Rest\Client\WalletGateway\Fee\Quote\QuoteFeeApiClientInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteRequestEntityInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteFeeEntityInterface;
use Payment\Wallet\Fee\Quote\Repository\Exception\QuoteNotFoundRepositoryException;

class QuoteFeeRepository implements QuoteFeeRepositoryInterface
{

    /**
     * @var QuoteFeeApiClientInterface
     */
    private $quoteFeeApiClient;

    /**
     * WalletPlanRepository constructor.
     * @param QuoteFeeApiClientInterface $quoteFeeApiClient
     */
    public function __construct(
        QuoteFeeApiClientInterface $quoteFeeApiClient
    ){
        $this->quoteFeeApiClient = $quoteFeeApiClient;
    }

    /**
     * @param QuoteRequestEntityInterface $quoteRequestEntity
     * @return QuoteFeeEntityInterface
     */
    public function getQuote(
        QuoteRequestEntityInterface $quoteRequestEntity
    ) : QuoteFeeEntityInterface
    {
         try {
            return $this
                ->quoteFeeApiClient
                ->getQuote(
                    $quoteRequestEntity->toArray()
                );
         } catch (QuoteFeeNotFoundException $e) {
             throw new QuoteNotFoundRepositoryException(
                 $e->getMessage()
             );
         }
    }
}
