<?php


namespace Payment\MTN\Remittance\Service;


use Payment\CashOut\Transaction\Entity\CashOutTransactionEntityInterface;
use Payment\CashOut\Transaction\Service\CashOutTransactionServiceInterface;
use Payment\MTN\Collection\Entity\RequestToPayEntityInterface;
use Payment\MTN\Remittance\Entity\MTNTransferEntity;
use Payment\MTN\Remittance\Repository\RemittanceRepositoryInterface;
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
     * MTNRemittanceService constructor.
     * @param RemittanceRepositoryInterface $mtnRemittanceRepository
     * @param CashOutTransactionServiceInterface $cashOutTransactionService
     * @param WalletGatewayServiceInterface $walletGatewayService
     */
    public function __construct(
        RemittanceRepositoryInterface $mtnRemittanceRepository,
        CashOutTransactionServiceInterface $cashOutTransactionService,
        WalletGatewayServiceInterface $walletGatewayService)
    {
        $this->mtnRemittanceRepository = $mtnRemittanceRepository;
        $this->cashOutTransactionService = $cashOutTransactionService;
        $this->walletGatewayService = $walletGatewayService;
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

        $referenceId = $this
            ->mtnRemittanceRepository
            ->transfer(
                new MTNTransferEntity(
                    $entity->getAmount(),
                    $entity->getCurrency(),
                    RequestToPayEntityInterface::PARTY_ID_TYPE_MSISDN,
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
}
