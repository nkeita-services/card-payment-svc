<?php


namespace Infrastructure\Api\Rest\Client\MTN\Collection;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Infrastructure\Api\Rest\Client\MTN\Collection\Exception\ReferenceIdAlreadyExistException;
use Infrastructure\Api\Rest\Client\MTN\Collection\Mapper\RequestToPayMapperInterface;
use Infrastructure\Api\Rest\Client\MTN\Collection\Response\RequestToPayResponseInterface;
use GuzzleHttp\Exception\ClientException;
use Ramsey\Uuid\Uuid;

class CollectionApiGuzzleHttpClient implements CollectionApiClientInterface
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var RequestToPayMapperInterface
     */
    private $requestToPayMapper;

    /**
     * RequestToPayApiGuzzleHttpClient constructor.
     * @param Client $guzzleClient
     * @param RequestToPayMapperInterface $requestToPayMapper
     */
    public function __construct(
        Client $guzzleClient,
        RequestToPayMapperInterface $requestToPayMapper
    )
    {
        $this->guzzleClient = $guzzleClient;
        $this->requestToPayMapper = $requestToPayMapper;
    }


    /**
     * @inheritDoc
     */
    public function createRequestToPay(array $requestToPayPayload): RequestToPayResponseInterface
    {
        try {
            $referenceId = Uuid::uuid4()->toString();
            $response = $this->guzzleClient->post('/collection/v1_0/requesttopay', [
                RequestOptions::JSON => $requestToPayPayload,
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

        return $this->requestToPayMapper->createRequestToPayResponseFromApiResponseAndReferenceId(
            $response,
            $referenceId
        );
    }

    /**
     * @inheritDoc
     */
    public function requestToPayStatus(string $referenceId): RequestToPayResponseInterface
    {
        try {
            $response = $this->guzzleClient->get(
                sprintf('/collection/v1_0/requesttopay/%s',$referenceId));

            return $this->requestToPayMapper->createRequestToPayResponseFromApiResponseAndReferenceId(
                $response,
                $referenceId
            );

        } catch (ClientException $exception) {

            throw $exception;
        }
    }
}
