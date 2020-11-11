<?php


namespace Payment\MTN\Remittance\Repository;


use Infrastructure\Api\Rest\Client\MTN\Remittance\RemittanceApiClientInterface;
use Payment\MTN\Remittance\Entity\MTNTransferEntityInterface;

class RemittanceRepository implements RemittanceRepositoryInterface
{

    /**
     * @var RemittanceApiClientInterface
     */
    private $remittanceApiClient;

    /**
     * RemittanceRepository constructor.
     * @param RemittanceApiClientInterface $remittanceApiClient
     */
    public function __construct(RemittanceApiClientInterface $remittanceApiClient)
    {
        $this->remittanceApiClient = $remittanceApiClient;
    }


    public function transfer(MTNTransferEntityInterface $MTNTransferEntity):string
    {
        $response = $this
            ->remittanceApiClient
            ->transfer(
                [
                    'amount' => $MTNTransferEntity->getAmount(),
                    'currency' => $MTNTransferEntity->getCurrency(),
                    'externalId' => $MTNTransferEntity->getExternalId(),
                    'payee' => [
                        'partyIdType' => $MTNTransferEntity->getPartyIdType(),
                        'partyId' => $MTNTransferEntity->getPartyId()
                    ],
                    'payerMessage' => $MTNTransferEntity->getPayerMessage(),
                    'payeeNote' => $MTNTransferEntity->getPayeeNote()
                ]
            );
        return $response->getReferenceId();
    }

    /**
     * @inheritDoc
     */
    public function transferStatus(string $referenceId): string
    {
        $response = $this
            ->remittanceApiClient
            ->transferStatus(
                $referenceId
            );

        return $response->getData()['status'];
    }
}
