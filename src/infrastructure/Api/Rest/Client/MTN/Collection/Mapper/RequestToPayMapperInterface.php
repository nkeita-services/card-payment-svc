<?php


namespace Infrastructure\Api\Rest\Client\MTN\Collection\Mapper;


use Infrastructure\Api\Rest\Client\MTN\Collection\Response\RequestToPayResponseInterface;
use Psr\Http\Message\ResponseInterface;

interface RequestToPayMapperInterface
{
    /**
     * @param ResponseInterface $response
     * @return RequestToPayResponseInterface
     */
    public function createRequestToPayResponseFromApiResponse(
        ResponseInterface $response
    ):RequestToPayResponseInterface;

}
