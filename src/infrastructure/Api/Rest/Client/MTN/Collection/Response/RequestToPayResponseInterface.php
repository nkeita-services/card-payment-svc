<?php


namespace Infrastructure\Api\Rest\Client\MTN\Collection\Response;


interface RequestToPayResponseInterface
{
    /**
     * @return string
     */
    public function getReferenceId(): string;
}
