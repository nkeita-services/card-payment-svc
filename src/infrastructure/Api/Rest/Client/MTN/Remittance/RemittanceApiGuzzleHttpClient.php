<?php


namespace Infrastructure\Api\Rest\Client\MTN\Remittance;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Infrastructure\Api\Rest\Client\MTN\Collection\Exception\ReferenceIdAlreadyExistException;
use Infrastructure\Api\Rest\Client\MTN\Remittance\Mapper\TransferMapper;
use Infrastructure\Api\Rest\Client\MTN\Remittance\Response\TransferResponseInterface;
use Ramsey\Uuid\Uuid;

class RemittanceApiGuzzleHttpClient implements RemittanceApiClientInterface
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var TransferMapper
     */
    private $transferMapper;

    /**
     * RemittanceApiGuzzleHttpClient constructor.
     * @param Client $guzzleClient
     * @param TransferMapper $transferMapper
     */
    public function __construct(Client $guzzleClient, TransferMapper $transferMapper)
    {
        $this->guzzleClient = $guzzleClient;
        $this->transferMapper = $transferMapper;
    }


    /**
     * @inheritDoc
     */
    public function transfer(array $transferPayload): TransferResponseInterface
    {
        try {
            $referenceId = Uuid::uuid4()->toString();
            $response = $this->guzzleClient->post('/remittance/v1_0/transfer', [
                RequestOptions::JSON => $transferPayload,
                RequestOptions::HEADERS => [
                    'X-Reference-Id'=> $referenceId,
                ]
            ]);
        } catch (ClientException $exception) {
            if (409 == $exception->getResponse()->getStatusCode()) {
                throw ReferenceIdAlreadyExistException::fromClientException(
                    $exception
                );
            }

            throw $exception;
        }

        return $this->transferMapper->createTransferResponseFromApiResponseAndReferenceId(
            $response,
            $referenceId
        );
    }

    /**
     * @inheritDoc
     */
    public function transferStatus(
        string $referenceId
    ): TransferResponseInterface{
        try {
            $response = $this->guzzleClient->get(
                sprintf('/remittance/v1_0/transfer/%s',$referenceId));

            return $this
                ->transferMapper
                ->createTransferResponseFromApiResponseAndReferenceId(
                    $response,
                    $referenceId
                );

        } catch (ClientException $exception) {

            throw $exception;
        }
    }
}
