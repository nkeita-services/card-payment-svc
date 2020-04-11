<?php


namespace Infrastructure\Api\Rest\Client\MTN\Collection;


use Infrastructure\Api\Rest\Client\MTN\Collection\Response\RequestToPayResponseInterface;

interface RequestToPayApiClientInterface
{

    /**
     * @param array $requestToPay
     * @return RequestToPayResponseInterface
     */
    public function create(array $requestToPay): RequestToPayResponseInterface;
}
