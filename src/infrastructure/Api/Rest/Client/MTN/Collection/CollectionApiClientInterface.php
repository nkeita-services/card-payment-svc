<?php


namespace Infrastructure\Api\Rest\Client\MTN\Collection;


use Infrastructure\Api\Rest\Client\MTN\Collection\Response\RequestToPayResponseInterface;

interface CollectionApiClientInterface
{

    /**
     * @param array $requestToPayPayload
     * @return RequestToPayResponseInterface
     */
    public function createRequestToPay(array $requestToPayPayload): RequestToPayResponseInterface;

    /**
     * @param string $referenceId
     * @return RequestToPayResponseInterface
     */
    public function requestToPayStatus(
        string $referenceId
    ):RequestToPayResponseInterface;
}
