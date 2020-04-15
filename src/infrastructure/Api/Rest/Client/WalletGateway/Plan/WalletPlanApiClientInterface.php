<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\Plan;


use Payment\Wallet\Plan\Entity\WalletPlanEntityInterface;

interface WalletPlanApiClientInterface
{
    /**
     * @param string $planId
     * @return WalletPlanEntityInterface
     */
    public function get(
        string $planId
    ):WalletPlanEntityInterface;
}
