<?php


namespace Infrastructure\Api\Rest\Client\MTN\Collection\Exception;
use InvalidArgumentException;
use GuzzleHttp\Exception\ClientException;

class ReferenceIdAlreadyExistException extends InvalidArgumentException
{

    /**
     * @param ClientException $clientException
     * @return ReferenceIdAlreadyExistException
     */
    public static function  fromClientException(ClientException $clientException): ReferenceIdAlreadyExistException
    {
        return new static(
            $clientException->getResponse()->getBody()->getContents()
        );
    }
}
