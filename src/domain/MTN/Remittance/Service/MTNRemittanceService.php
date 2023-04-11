<?php


namespace Payment\MTN\Remittance\Service;


use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;
use Payment\CashOut\Transaction\Service\CashOutTransactionServiceInterface;
use Payment\MTN\Collection\Entity\RequestToPayEntityInterface;
use Payment\MTN\Remittance\Entity\MTNTransferEntity;
use Payment\MTN\Remittance\Repository\RemittanceRepositoryInterface;
use Payment\Wallet\Fee\Quote\Service\Exception\QuoteNotFoundServiceException;
use Payment\Wallet\Fee\Quote\Service\QuoteFeeServiceInterface;
use Payment\Wallet\WalletGateway\WalletGatewayServiceInterface;

class MTNRemittanceService implements MTNRemittanceServiceInterface
{

    /**
     * @var RemittanceRepositoryInterface
     */
    private $mtnRemittanceRepository;

    /**
     * @var CashOutTransactionServiceInterface
     */
    private $cashOutTransactionService;


    /**
     * @var WalletGatewayServiceInterface
     */
    private $walletGatewayService;

    /**
     * @var QuoteFeeServiceInterface
     */
    private $quoteFeeService;

    /**
     * MTNRemittanceService constructor.
     * @param RemittanceRepositoryInterface $mtnRemittanceRepository
     * @param CashOutTransactionServiceInterface $cashOutTransactionService
     * @param WalletGatewayServiceInterface $walletGatewayService
     * @param QuoteFeeServiceInterface $quoteFeeService
     */
    public function __construct(
        RemittanceRepositoryInterface $mtnRemittanceRepository,
        CashOutTransactionServiceInterface $cashOutTransactionService,
        WalletGatewayServiceInterface $walletGatewayService,
        QuoteFeeServiceInterface $quoteFeeService
    ){
        $this->mtnRemittanceRepository = $mtnRemittanceRepository;
        $this->cashOutTransactionService = $cashOutTransactionService;
        $this->walletGatewayService = $walletGatewayService;
        $this->quoteFeeService = $quoteFeeService;
    }


    /**
     * @inheritDoc
     */
    public function transferFromCashOutRequest(
        CashOutTransactionEntityInterface $entity
    ): CashOutTransactionEntityInterface{

        $entity->setCurrency(
            $this->walletGatewayService->accountCurrencyFromUserIdAndAccountId(
                $entity->getOriginatorId(),
                $entity->getAccountId()
            )
        );

        $entity = $this->cashOutTransactionService
            ->store(
                $entity
            );

        try {
            $fees = $this->quoteFeeService
                ->getCashOutQuotes($entity);
            $fees->setEventType(
                CashInTransactionEntityInterface::FEES_EVENT
            );
            $fees->setTransactionId(
                $entity
                    ->getTransactionId()
            );
            $this->cashOutTransactionService
                ->addTransactionFees(
                    $entity->getTransactionId(),
                    $fees->toArray()
                );
        } catch (QuoteNotFoundServiceException $e) {}

        $referenceId = $this
            ->mtnRemittanceRepository
            ->transfer(
                new MTNTransferEntity(
                    $entity->getAmount(),
                    $entity->getCurrency(),
                    RequestToPayEntityInterface::PARTY_ID_TYPE_MSISDN,
                    $entity->getOriginatorExternalMobileNumber() ??
                    $this->walletGatewayService->mobileNumberFromUserId(
                        $entity->getOriginatorId()
                    ),
                    $message ?? CashOutTransactionEntityInterface::DESCRIPTION_DEFAULT,
                    $note ?? CashOutTransactionEntityInterface::DESCRIPTION_DEFAULT,
                    $entity->getTransactionId()
                )
            );

        $this
            ->cashOutTransactionService
            ->addAdditionalInfo(
                $entity->getTransactionId(),
                [
                    'referenceId' => $referenceId
                ]
            );

        return $entity;
    }

    /**
     * @inheritDoc
     */
    public function transferStatus(
        string $transactionId
    ): CashOutTransactionEntityInterface
    {

        $transaction = $this
            ->cashOutTransactionService
            ->fetchWithTransactionId(
                $transactionId
            );

        $status = $this
            ->mtnRemittanceRepository
            ->transferStatus(
                $transaction->getExtras()['referenceId']
            );

        return $this->cashOutTransactionService
            ->updateTransactionStatus(
                $transaction->getTransactionId(),
                $status
            );

    }
}
