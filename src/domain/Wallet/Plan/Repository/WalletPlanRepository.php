<?php


namespace Payment\Wallet\Plan\Repository;


use Infrastructure\Api\Rest\Client\WalletGateway\Plan\WalletPlanApiClientInterface;
use Payment\Wallet\Plan\Entity\WalletPlanEntityInterface;

class WalletPlanRepository implements WalletPlanRepositoryInterface
{
    /**
     * @var WalletPlanApiClientInterface
     */
    private $walletPlanApiClient;

    /**
     * WalletPlanRepository constructor.
     * @param WalletPlanApiClientInterface $walletPlanApiClient
     */
    public function __construct(
        WalletPlanApiClientInterface $walletPlanApiClient
    ){
        $this->walletPlanApiClient = $walletPlanApiClient;
    }


    /**
     * @inheritDoc
     */
    public function fetchWithWalletPlanId(
        string $walletPlanId
    ): WalletPlanEntityInterface{
       return $this->walletPlanApiClient->get(
            $walletPlanId
        );
    }
}
