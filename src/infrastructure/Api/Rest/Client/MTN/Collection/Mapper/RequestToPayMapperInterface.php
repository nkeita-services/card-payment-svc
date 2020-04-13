<?php


namespace Infrastructure\Api\Rest\Client\MTN\Collection\Mapper;


use Infrastructure\Api\Rest\Client\MTN\Collection\Response\RequestToPayResponseInterface;
use Psr\Http\Message\ResponseInterface;

interface RequestToPayMapperInterface
{
    /**
     * @param ResponseInterface $response
     * @param string $referenceId
     * @return RequestToPayResponseInterface
     */
    public function createRequestToPayResponseFromApiResponseAndReferenceId(
        ResponseInterface $response,
        string $referenceId
    ):RequestToPayResponseInterface;

}
