<?php


namespace Infrastructure\Api\Rest\Client\MTN\Collection;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Infrastructure\Api\Rest\Client\MTN\Collection\Exception\ReferenceIdAlreadyExistException;
use Infrastructure\Api\Rest\Client\MTN\Collection\Mapper\RequestToPayMapperInterface;
use Infrastructure\Api\Rest\Client\MTN\Collection\Response\RequestToPayResponseInterface;
use GuzzleHttp\Exception\ClientException;

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
            $response = $this->guzzleClient->post('/collection/v1_0/requesttopay', [
                RequestOptions::JSON => $requestToPayPayload
            ]);
        } catch (ClientException $exception) {
            if (409 == $exception->getResponse()->getStatusCode()) {
                throw ReferenceIdAlreadyExistException::fromClientException(
                    $exception
                );
            }

            throw $exception;
        }

        return $this->requestToPayMapper->createRequestToPayResponseFromApiResponse(
            $response
        );
    }
}
