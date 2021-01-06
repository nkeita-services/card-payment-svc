<?php


namespace Infrastructure\Api\Rest\Client\Account\Mapper;


use Payment\Account\Entity\AccountBalanceOperationResultInterface;
use Psr\Http\Message\ResponseInterface;

interface AccountBalanceOperationResultMapperInterface
{
    /**
     * @param ResponseInterface $response
     * @return AccountBalanceOperationResultInterface
     */
    public function fromApiResponse(
        ResponseInterface $response
    ):AccountBalanceOperationResultInterface;
}
