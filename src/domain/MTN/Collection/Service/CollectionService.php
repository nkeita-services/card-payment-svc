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
    ): string{
        $account = $this
            ->accountService
            ->fetchWithUserIdAndAccountId(
                $originator['originatorId'],
                $accountId
            );

        $user= $this
            ->userService
            ->fetchFromUserId($originator['originatorId']);

        $this
            ->cashInTransactionService
            ->store(
                new CashInTransactionEntity(
                    null,
                    $amount,
                    'EUR',
                    $message ?? 'request to pay',
                    $accountId,
                    $originator,
                    CashInTransactionEntityInterface::STATUS_PENDING,
                    mktime()
                )
            );

        try{
            $this
                ->collectionRepository
                ->requestToPay(
                    new RequestToPayEntity(
                        $amount,
                        'EUR',
                        'MSISDN',
                        $user->getMobileNumber(),
                        $message ?? 'request to pay',
                        $note ?? 'request to pay',
                        '78ba84fe-43b7-4dd4-b2b7-c9326a02f458'
                    )
                );
        }catch (RequestToPayException $exception){
            throw new RequestToPayServiceException(
                'Unable to fullfil cash-in request'
            );
        }
    }
}
