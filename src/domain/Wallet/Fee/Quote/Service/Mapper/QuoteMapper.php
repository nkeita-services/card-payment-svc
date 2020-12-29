<?php


namespace Payment\Wallet\Fee\Quote\Service\Mapper;


use Payment\Account\Service\AccountServiceInterface;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;
use Payment\Wallet\Fee\Quote\Entity\QuoteRequestEntity;
use Payment\Wallet\Fee\Quote\Entity\QuoteRequestEntityInterface;

class QuoteMapper implements QuoteMapperInterface
{
    /**
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * QuoteMapper constructor.
     * @param AccountServiceInterface $accountService
     */
    public function __construct(
        AccountServiceInterface $accountService
    ){
        $this->accountService = $accountService;
    }

    /**
     * @param CashInTransactionEntityInterface $transaction
     * @return QuoteRequestEntityInterface
     */
    public function createQuotePayloadFromTransaction(
        CashInTransactionEntityInterface $transaction
    ):QuoteRequestEntityInterface
    {

        $accountData = $this
            ->accountService
            ->fetchWithUserIdAndAccountId(
                $transaction->getOriginatorId(),
                $transaction->getAccountId()
            );

        return QuoteRequestEntity::fromArray([
            'paymentMean'=> $transaction->getType(),
            'amount'=> floatval($transaction->getAmount()),
            'accountId'=>$transaction->getAccountId(),
            'walletOrganizations'=> $accountData->getOrganizations(),
            'regionId'=> $transaction->getRegionId(),
            'operation'=> $transaction->getDescription(),
            'currency'=> $transaction->getCurrency(),
            'originator' =>  $transaction->getOriginator()
        ]);
    }

    /**
     * @param CashOutTransactionEntityInterface $transaction
     * @return QuoteRequestEntityInterface
     */
    public function createQuotePayloadFromCashOut(
        CashOutTransactionEntityInterface $transaction
    ):QuoteRequestEntityInterface
    {
        $accountData = $this
            ->accountService
            ->fetchWithUserIdAndAccountId(
                $transaction->getOriginatorId(),
                $transaction->getAccountId()
            );

        return QuoteRequestEntity::fromArray([
            'paymentMean'=> $transaction->getType(),
            'amount'=> floatval($transaction->getAmount()),
            'accountId'=>$transaction->getAccountId(),
            'walletOrganizations'=> $accountData->getOrganizations(),
            'regionId'=> $transaction->getRegionId(),
            'operation'=> $transaction->getDescription(),
            'currency'=> $transaction->getCurrency(),
            'originator' =>  $transaction->getOriginator()
        ]);
    }
}
