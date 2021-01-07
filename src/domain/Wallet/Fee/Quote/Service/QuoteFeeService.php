<?php


namespace Payment\Wallet\Fee\Quote\Service;


use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteRequestEntityInterface;
use Payment\Wallet\Fee\Quote\Repository\Exception\QuoteNotFoundRepositoryException;
use Payment\Wallet\Fee\Quote\Service\Exception\QuoteNotFoundServiceException;
use Payment\Wallet\Fee\Quote\Service\Mapper\QuoteMapperInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteFeeEntityInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteFeeEntity;
use Payment\Wallet\Fee\Quote\Repository\QuoteFeeRepositoryInterface;

class QuoteFeeService implements QuoteFeeServiceInterface
{
    const NBK = "Nbk";
    /**
     * @var QuoteFeeRepositoryInterface
     */
    private $quoteFeeRepository;


    /**c
     * @var QuoteMapperInterface
     */
    private $quoteMapper;

    /**
     * QuoteFeeService constructor.
     * @param QuoteFeeRepositoryInterface $quoteFeeRepository
     * @param QuoteMapperInterface $quoteMapper
     */
    public function __construct(
        QuoteFeeRepositoryInterface $quoteFeeRepository,
        QuoteMapperInterface $quoteMapper
    )
    {
        $this->quoteFeeRepository = $quoteFeeRepository;
        $this->quoteMapper = $quoteMapper;
    }

    /**
     * @param QuoteRequestEntityInterface $quoteRequestEntity
     * @return QuoteFeeEntityInterface
     */
    public function getQuote(
        QuoteRequestEntityInterface $quoteRequestEntity
    ) : QuoteFeeEntityInterface
    {
        return $this
            ->quoteFeeRepository
            ->getQuote(
                $quoteRequestEntity
            );
    }

    public function calculateQuotes(
        QuoteRequestEntityInterface $quoteRequestEntity
    ) : QuoteFeeEntityInterface
    {
        try {
            $paymentMean = $this
                ->getQuote(
                    $quoteRequestEntity
                );

            $nbk =  $this->getQuote(
                $quoteRequestEntity
                    ->setPaymentMean(
                        self::NBK
                    )
            );

            return QuoteFeeEntity::fromArray([
                'walletOrganizations' => $paymentMean->getWalletOrganizations(),
                'regions' => $paymentMean->getRegions(),
                'paymentMean' => $paymentMean->getPaymentMean(),
                'nbk' => $nbk->getPaymentMean()
            ]);

        } catch (QuoteNotFoundRepositoryException $e) {
            throw new QuoteNotFoundServiceException(
                $e->getMessage()
            );
        }

    }

    /**
     * @param CashInTransactionEntityInterface $transaction
     * @return QuoteFeeEntityInterface
     */
    public function getQuotes(
        CashInTransactionEntityInterface $transaction
    ) : QuoteFeeEntityInterface
    {

        $quoteRequestEntity = $this
            ->quoteMapper
            ->createQuotePayloadFromTransaction(
                $transaction
            );

        try {

            return $this->calculateQuotes(
                $quoteRequestEntity
            );

        } catch (QuoteNotFoundRepositoryException $e) {
            throw new QuoteNotFoundServiceException(
                $e->getMessage()
            );
        }

    }

    /**
     * @param CashOutTransactionEntityInterface $transaction
     * @return QuoteFeeEntityInterface
     */
    public function getCashOutQuotes(
        CashOutTransactionEntityInterface $transaction
    ) : QuoteFeeEntityInterface
    {
        try {
            $quoteRequestEntity = $this
                ->quoteMapper
                ->createQuotePayloadFromCashOut(
                    $transaction
                );
        } catch (QuoteNotFoundRepositoryException $e) {
            throw new QuoteNotFoundServiceException(
                $e->getMessage()
            );
        }


        return $this->calculateQuotes(
            $quoteRequestEntity
        );

    }
}
