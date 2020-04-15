<?php


namespace Payment\Wallet\Plan\Service;


use Payment\Wallet\Plan\Entity\WalletPlanEntityInterface;
use Payment\Wallet\Plan\Repository\WalletPlanRepositoryInterface;

class WalletPlanService implements WalletPlanServiceInterface
{
    /**
     * @var WalletPlanRepositoryInterface
     */
    private $walletPlanRepository;

    /**
     * WalletPlanService constructor.
     * @param WalletPlanRepositoryInterface $walletPlanRepository
     */
    public function __construct(
        WalletPlanRepositoryInterface $walletPlanRepository
    ){
        $this->walletPlanRepository = $walletPlanRepository;
    }


    /**
     * @inheritDoc
     */
    public function fromWalletPlanId(
        string $walletPlanId
    ): WalletPlanEntityInterface{
        return $this->walletPlanRepository->fetchWithWalletPlanId(
            $walletPlanId
        );
    }
}
