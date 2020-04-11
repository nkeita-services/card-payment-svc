<?php


namespace Infrastructure\Api\Rest\Client\MTN\Collection;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Infrastructure\Api\Rest\Client\MTN\Collection\Mapper\RequestToPayMapperInterface;
use Infrastructure\Api\Rest\Client\MTN\Collection\Response\RequestToPayResponseInterface;

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
    ){
        $this->guzzleClient = $guzzleClient;
        $this->requestToPayMapper = $requestToPayMapper;
    }


    /**
     * @inheritDoc
     */
    public function createRequestToPay(array $requestToPayPayload): RequestToPayResponseInterface
    {
        $response = $this->guzzleClient->post('/v1_0/requesttopay', [
            RequestOptions::JSON => $requestToPayPayload
        ]);

        return $this->requestToPayMapper->createRequestToPayResponseFromApiResponse(
            $response
        );
    }
}