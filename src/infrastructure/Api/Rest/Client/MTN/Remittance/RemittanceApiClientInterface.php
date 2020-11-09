<?php


namespace Infrastructure\Api\Rest\Client\MTN\Remittance;


use Infrastructure\Api\Rest\Client\MTN\Remittance\Response\TransferResponse;
use Infrastructure\Api\Rest\Client\MTN\Remittance\Response\TransferResponseInterface;

interface RemittanceApiClientInterface
{

    /**
     * @param array $transferPayload
     * @return TransferResponse
     */
    public function transfer(
        array $transferPayload
    ):TransferResponseInterface;
}
