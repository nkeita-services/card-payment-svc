<?php


namespace Payment\MTN\Collection\Service;


use Payment\CashIn\Transaction\CashInTransactionEntity;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;
use Payment\MTN\Collection\Entity\RequestToPayEntity;
use Payment\MTN\Collection\Entity\RequestToPayEntityInterface;
use Payment\MTN\Collection\Repository\CollectionRepositoryInterface;
use Payment\MTN\Collection\Repository\Exception\RequestToPayException;
use Payment\MTN\Collection\Service\Exception\RequestToPayException as RequestToPayServiceException;
use Payment\Wallet\Fee\Quote\Service\QuoteFeeServiceInterface;
use Payment\Wallet\WalletGateway\WalletGatewayServiceInterface;

class CollectionService implements CollectionServiceInterface
{

    /**
     * @var CollectionRepositoryInterface
     */
    private $collectionRepository;

    /**
     * @var CashInTransactionServiceInterface
     */
    private $cashInTransactionService;

    /**
     * @var WalletGatewayServiceInterface
     */
    private $walletGatewayService;

    /**
     * @var QuoteFeeServiceInterface
     */
    private $quoteFeeService;

    /**
     * CollectionService constructor.
     * @param CollectionRepositoryInterface $collectionRepository
     * @param CashInTransactionServiceInterface $cashInTransactionService
     * @param WalletGatewayServiceInterface $walletGatewayService
     * @param QuoteFeeServiceInterface $quoteFeeService
     */
    public function __construct(
        CollectionRepositoryInterface $collectionRepository,
        CashInTransactionServiceInterface $cashInTransactionService,
        WalletGatewayServiceInterface $walletGatewayService,
        QuoteFeeServiceInterface $quoteFeeService
    ){
        $this->collectionRepository = $collectionRepository;
        $this->cashInTransactionService = $cashInTransactionService;
        $this->walletGatewayService = $walletGatewayService;
        $this->quoteFeeService = $quoteFeeService;
    }


    /**
     * @inheritDoc
     */
    public function requestToPay(
        string $accountId,
        float $amount,
        array $originator,
        array $regions = null,
        string $message = null,
        string $note = null
    ): CashInTransactionEntityInterface{
        try{
            $cashInTransactionEntity = $this
                ->cashInTransactionService
                ->store(
                    new CashInTransactionEntity(
                        CashInTransactionEntityInterface::TYPE_MTN,
                        null,
                        $amount,
                        $this->walletGatewayService->accountCurrencyFromUserIdAndAccountId(
                            $originator['originatorId'],
                            $accountId
                        ),
                        $message ?? CashInTransactionEntityInterface::DESCRIPTION_DEFAULT,
                        $accountId,
                        $regions,
                        $originator,
                        CashInTransactionEntityInterface::STATUS_PENDING,
                        time()
                    )
                );

            /*$fees = $this->quoteFeeService->getQuotes($cashInTransactionEntity);
            $this->cashInTransactionService
                ->addTransactionFees(
                    $cashInTransactionEntity->getTransactionId(),
                    $fees->toArray()
                );*/

            $referenceId = $this
                ->collectionRepository
                ->requestToPay(
                    new RequestToPayEntity(
                        $amount,
                        $this->walletGatewayService->accountCurrencyFromUserIdAndAccountId(
                            $originator['originatorId'],
                            $accountId
                        ),
                        RequestToPayEntityInterface::PARTY_ID_TYPE_MSISDN,
                        $this->walletGatewayService->mobileNumberFromUserId($originator['originatorId']),
                        $message ?? CashInTransactionEntityInterface::DESCRIPTION_DEFAULT,
                        $note ?? CashInTransactionEntityInterface::DESCRIPTION_DEFAULT,
                        $cashInTransactionEntity->getTransactionId()
                    )
                );

            $this
                ->cashInTransactionService
                ->addAdditionalInfo(
                    $cashInTransactionEntity->getTransactionId(),
                    [
                        'referenceId' => $referenceId
                    ]
                );

            return $cashInTransactionEntity;

        }catch (RequestToPayException $exception){
            throw new RequestToPayServiceException(
                'Unable to fulfill cash-in request'
            );
        }


    }

    /**
     * @inheritDoc
     */
    public function requestToPayStatus(
        string $transactionId
    ): CashInTransactionEntityInterface
    {

        $transaction = $this
            ->cashInTransactionService
            ->fetchWithTransactionId(
                $transactionId
            );

        $status = $this->collectionRepository
            ->requestToPayStatus(
                $transaction->getExtras()['referenceId']
            );

        return $this->cashInTransactionService
            ->updateTransactionStatus(
                $transaction->getTransactionId(),
                $status
            );

    }
}
