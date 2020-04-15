<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\Plan;


use GuzzleHttp\Client;
use Infrastructure\Api\Rest\Client\WalletGateway\Plan\Mapper\WalletPlanMapperInterface;
use Infrastructure\Api\Rest\Client\WalletGateway\User\Mapper\UserMapperInterface;
use Payment\Wallet\Plan\Entity\WalletPlanEntityInterface;

class WalletPlanApiGuzzleHttpClient implements WalletPlanApiClientInterface
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var WalletPlanMapperInterface
     */
    private $walletPlanMapper;

    /**
     * WalletPlanApiGuzzleHttpClient constructor.
     * @param Client $guzzleClient
     * @param WalletPlanMapperInterface $walletPlanMapper
     */
    public function __construct(
        Client $guzzleClient,
        WalletPlanMapperInterface $walletPlanMapper
    ){
        $this->guzzleClient = $guzzleClient;
        $this->walletPlanMapper = $walletPlanMapper;
    }


    /**
     * @inheritDoc
     */
    public function get(
        string $planId
    ): WalletPlanEntityInterface{

        $response = $this->guzzleClient->get(
            sprintf('v1/wallets/plans/%s', $planId)
        );

        return $this->walletPlanMapper->createWalletPlanFromApiResponse(
            $response
        );
    }
}
