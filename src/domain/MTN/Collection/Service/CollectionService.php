<?php


namespace Payment\MTN\Collection\Service;


use Payment\Account\Service\AccountServiceInterface;
use Payment\MTN\Collection\Entity\RequestToPayEntity;
use Payment\MTN\Collection\Repository\CollectionRepositoryInterface;
use Payment\MTN\Collection\Repository\Exception\RequestToPayException;
use Payment\MTN\Collection\Service\Exception\RequestToPayException as RequestToPayServiceException;

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
     * CollectionService constructor.
     * @param CollectionRepositoryInterface $collectionRepository
     * @param AccountServiceInterface $accountService
     */
    public function __construct(
        CollectionRepositoryInterface $collectionRepository,
        AccountServiceInterface $accountService
    ){
        $this->collectionRepository = $collectionRepository;
        $this->accountService = $accountService;
    }


    /**
     * @inheritDoc
     */
    public function requestToPay(
        string $accountId,
        float $amount,
        string $message = null,
        string $note = null
    ){
        $account = $this
            ->accountService
            ->fetchWithAccountId($accountId);

        //die($account->get)
        try{
            $this
                ->collectionRepository
                ->requestToPay(
                    new RequestToPayEntity(
                        $amount,
                        'EUR',
                        'MSISDN',
                        '46733123454',
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
