<?php


namespace Payment\MTN\Collection\Repository;


use Infrastructure\Api\Rest\Client\MTN\Collection\CollectionApiClientInterface;
use Infrastructure\Api\Rest\Client\MTN\Collection\Exception\ReferenceIdAlreadyExistException;
use Payment\MTN\Collection\Entity\RequestToPayEntityInterface;
use Payment\MTN\Collection\Repository\Exception\RequestToPayException;

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
    )
    {
        $this->collectionApiClient = $collectionApiClient;
    }


    /**
     * @inheritDoc
     */
    public function requestToPay(
        RequestToPayEntityInterface $requestToPayEntity
    ): bool{
        try {
            $response = $this
                ->collectionApiClient
                ->createRequestToPay(
                    [
                        'amount' => $requestToPayEntity->getAmount(),
                        'currency' => $requestToPayEntity->getCurrency(),
                        'externalId' => $requestToPayEntity->getExternalId(),
                        'payer' => [
                            'partyIdType' => $requestToPayEntity->getPartyIdType(),
                            'partyId' => $requestToPayEntity->getPartyId()
                        ],
                        'payerMessage' => $requestToPayEntity->getPayerMessage(),
                        'payeeNote' => $requestToPayEntity->getPayeeNote()
                    ]
                );
        } catch (ReferenceIdAlreadyExistException $exception) {
            throw new RequestToPayException(
               'Error when sending request to pay request'
            );
        }

        return true;
    }
}
