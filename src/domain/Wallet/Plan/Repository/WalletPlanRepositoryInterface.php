<?php


namespace Payment\Wallet\Plan\Repository;


use Payment\Wallet\Plan\Entity\WalletPlanEntityInterface;

interface WalletPlanRepositoryInterface
{

    /**
     * @param string $walletPlanId
     * @return WalletPlanEntityInterface
     */
    public function fetchWithWalletPlanId(
        string $walletPlanId
    ):WalletPlanEntityInterface;
}
