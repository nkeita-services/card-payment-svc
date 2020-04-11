<?php


namespace Payment\MTN\Collection\Service;


use Payment\MTN\Collection\Entity\RequestToPayEntity;
use Payment\MTN\Collection\Repository\CollectionRepositoryInterface;

class CollectionService implements CollectionServiceInterface
{

    /**
     * @var CollectionRepositoryInterface
     */
    private $collectionRepository;

    /**
     * CollectionService constructor.
     * @param CollectionRepositoryInterface $collectionRepository
     */
    public function __construct(
        CollectionRepositoryInterface $collectionRepository
    ){
        $this->collectionRepository = $collectionRepository;
    }


    /**
     * @inheritDoc
     */
    public function requestToPay(
        string $accountId,
        float $amount
    ){
        $this
            ->collectionRepository
            ->requestToPay(
                new RequestToPayEntity(
                    $amount,
                    'EUR',
                    'MSISDN',
                    '46733123454',
                    'pay',
                    'pay',
                    '78ba84fe-43b7-4dd4-b2b7-c9326a02f458'
                )
            );
    }
}
