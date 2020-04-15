<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\Plan\Mapper;


use Payment\Wallet\Plan\Entity\WalletPlanEntity;
use Payment\Wallet\Plan\Entity\WalletPlanEntityInterface;
use Psr\Http\Message\ResponseInterface;

class WalletPlanMapper implements WalletPlanMapperInterface
{

    /**
     * @inheritDoc
     */
    public function createWalletPlanFromApiResponse(
        ResponseInterface $response
    ): WalletPlanEntityInterface
    {
        $walletPlanData = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return WalletPlanEntity::fromArray(
            $walletPlanData['data']['walletPlan']
        );
    }
}
