<?php


namespace Payment\MTN\Collection\Repository;


use Infrastructure\Api\Rest\Client\MTN\Collection\CollectionApiClientInterface;
use Payment\MTN\Collection\Entity\RequestToPayEntityInterface;

class CollectionRepository implements CollectionRepositoryInterface
{

    /**
     * @var CollectionApiClientInterface
     */
    private $collectionApiClient;

    /**
     * CollectionRepository constructor.
     * @param CollectionApiClientInterface $collectionApiClient
     */
    public function __construct(
        CollectionApiClientInterface $collectionApiClient
    ){
        $this->collectionApiClient = $collectionApiClient;
    }


    /**
     * @inheritDoc
     */
    public function requestToPay(
        RequestToPayEntityInterface $requestToPayEntity
    ): bool{
        $response = $this
            ->collectionApiClient
            ->createRequestToPay(
                [
                    'amount'=>$requestToPayEntity->getAmount(),
                    'currency'=>$requestToPayEntity->getCurrency(),
                    'externalId'=>$requestToPayEntity->getExternalId(),
                    'payer'=>[
                        'partyIdType'=> $requestToPayEntity->getPartyIdType(),
                        'partyId'=>$requestToPayEntity->getPartyId()
                    ],
                    'payerMessage'=>$requestToPayEntity->getPayerMessage(),
                    'payeeNote'=>$requestToPayEntity->getPayeeNote()
                ]
            );

        return true;
    }
}
