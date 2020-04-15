<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\Plan\Mapper;


use Payment\Wallet\Plan\Entity\WalletPlanEntityInterface;
use Psr\Http\Message\ResponseInterface;

interface WalletPlanMapperInterface
{

    /**
     * @param ResponseInterface $response
     * @return WalletPlanEntityInterface
     */
    public function createWalletPlanFromApiResponse(
        ResponseInterface $response
    ):WalletPlanEntityInterface;
}
