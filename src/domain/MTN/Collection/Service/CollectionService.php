<?php


namespace Payment\MTN\Collection\Service;


use Payment\Account\Service\AccountServiceInterface;
use Payment\CashIn\Transaction\CashInTransactionEntity;
use Payment\CashIn\Transaction\CashInTransactionEntityInterface;
use Payment\CashIn\Transaction\Service\CashInTransactionServiceInterface;
use Payment\MTN\Collection\Entity\RequestToPayEntity;
use Payment\MTN\Collection\Repository\CollectionRepositoryInterface;
use Payment\MTN\Collection\Repository\Exception\RequestToPayException;
use Payment\MTN\Collection\Service\Exception\RequestToPayException as RequestToPayServiceException;
use Payment\Wallet\User\Service\UserServiceInterface;

class CollectionService implements CollectionServiceInterface
{

    /**
     * @var CollectionRepositoryInterface
     */
    private $collectionRepository;

    /**
     * @var AccountServiceInterface
     */
    private $accountService;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @var CashInTransactionServiceInterface
     */
    private $cashInTransactionService;

    /**
     * CollectionService constructor.
     * @param CollectionRepositoryInterface $collectionRepository
     * @param AccountServiceInterface $accountService
     * @param UserServiceInterface $userService
     * @param CashInTransactionServiceInterface $cashInTransactionService
     */
    public function __construct(
        CollectionRepositoryInterface $collectionRepository,
        AccountServiceInterface $accountService,
        UserServiceInterface $userService,
        CashInTransactionServiceInterface $cashInTransactionService
    ){
        $this->collectionRepository = $collectionRepository;
        $this->accountService = $accountService;
        $this->userService = $userService;
        $this->cashInTransactionService = $cashInTransactionService;
    }


    /**
     * @inheritDoc
     */
    public function requestToPay(
        string $accountId,
        float $amount,
        array $originator,
        string $message = null,
        string $note = null
    ): CashInTransactionEntityInterface{

        $account = $this
            ->accountService
            ->fetchWithUserIdAndAccountId(
                $originator['originatorId'],
                $accountId
            );

        $user= $this
            ->userService
            ->fetchFromUserId($originator['originatorId']);

        try{

            $cashInTransactionEntity = $this
                ->cashInTransactionService
                ->store(
                    new CashInTransactionEntity(
                        CashInTransactionEntityInterface::TYPE_MTN,
                        null,
                        $amount,
                        'EUR',
                        $message ?? CashInTransactionEntityInterface::DESCRIPTION_DEFAULT,
                        $accountId,
                        $originator,
                        CashInTransactionEntityInterface::STATUS_PENDING,
                        time(),
                        null
                    )
                );

            $referenceId = $this
                ->collectionRepository
                ->requestToPay(
                    new RequestToPayEntity(
                        $amount,
                        'EUR',
                        'MSISDN',
                        $user->getMobileNumber(),
                        $message ?? CashInTransactionEntityInterface::DESCRIPTION_DEFAULT,
                        $note ?? CashInTransactionEntityInterface::DESCRIPTION_DEFAULT,
                        $cashInTransactionEntity->getTransactionId()
                    )
                );

        }catch (RequestToPayException $exception){
            throw new RequestToPayServiceException(
                'Unable to fullfil cash-in request'
            );
        }

        return $cashInTransactionEntity;
    }
}
