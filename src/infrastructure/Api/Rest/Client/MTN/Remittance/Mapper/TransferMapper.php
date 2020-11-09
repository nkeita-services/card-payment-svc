<?php


namespace Infrastructure\Api\Rest\Client\MTN\Remittance\Mapper;


use Infrastructure\Api\Rest\Client\MTN\Collection\Response\RequestToPayResponse;
use Infrastructure\Api\Rest\Client\MTN\Remittance\Response\TransferResponse;
use Infrastructure\Api\Rest\Client\MTN\Remittance\Response\TransferResponseInterface;
use Psr\Http\Message\ResponseInterface;

class TransferMapper implements TransferMapperInterface
{

    /**
     * @inheritDoc
     */
    public function createTransferResponseFromApiResponseAndReferenceId(
        ResponseInterface $response,
        string $referenceId
    ): TransferResponseInterface{
        $data = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return new TransferResponse(
            $referenceId,
            $data
        );
    }
}
