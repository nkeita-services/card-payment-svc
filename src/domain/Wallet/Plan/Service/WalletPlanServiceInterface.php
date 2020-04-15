<?php


namespace Payment\Wallet\Plan\Service;


use Payment\Wallet\Plan\Entity\WalletPlanEntityInterface;

interface WalletPlanServiceInterface
{

    /**
     * @param string $walletPlanId
     * @return WalletPlanEntityInterface
     */
    public function fromWalletPlanId(
        string $walletPlanId
    ):WalletPlanEntityInterface;
}
