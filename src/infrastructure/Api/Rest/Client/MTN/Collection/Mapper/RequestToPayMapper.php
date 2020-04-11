<?php


namespace Infrastructure\Api\Rest\Client\MTN\Collection\Mapper;


use Infrastructure\Api\Rest\Client\MTN\Collection\Response\RequestToPayResponse;
use Infrastructure\Api\Rest\Client\MTN\Collection\Response\RequestToPayResponseInterface;
use Psr\Http\Message\ResponseInterface;

class RequestToPayMapper implements RequestToPayMapperInterface
{

    /**
     * @inheritDoc
     */
    public function createRequestToPayResponseFromApiResponse(
        ResponseInterface $response
    ): RequestToPayResponseInterface{
        $data = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return new RequestToPayResponse();

    }
}
