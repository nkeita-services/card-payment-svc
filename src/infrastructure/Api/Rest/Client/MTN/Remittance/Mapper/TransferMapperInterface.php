<?php


namespace Infrastructure\Api\Rest\Client\MTN\Remittance\Mapper;


use Infrastructure\Api\Rest\Client\MTN\Remittance\Response\TransferResponseInterface;
use Psr\Http\Message\ResponseInterface;

interface TransferMapperInterface
{
    /**
     * @param ResponseInterface $response
     * @param string $referenceId
     * @return TransferResponseInterface
     */
    public function createTransferResponseFromApiResponseAndReferenceId(
        ResponseInterface $response,
        string $referenceId
    ): TransferResponseInterface;
}
