<?php


namespace Infrastructure\Api\Rest\Client\Account;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Infrastructure\Api\Rest\Client\Account\Mapper\AccountBalanceOperationResultMapperInterface;
use Infrastructure\Api\Rest\Client\Account\Mapper\AccountMapperInterface;
use Payment\Account\Entity\AccountBalanceOperationResultInterface;
use Payment\Account\Entity\AccountEntityInterface;

class AccountApiGuzzleHttpClient implements AccountApiClientInterface
{
    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * @var AccountMapperInterface
     */
    private $accountMapper;

    /**
     * @var AccountBalanceOperationResultMapperInterface
     */
    private $accountBalanceOperationResultMapper;

    /**
     * AccountApiGuzzleHttpClient constructor.
     * @param Client $guzzleClient
     * @param AccountMapperInterface $accountMapper
     * @param AccountBalanceOperationResultMapperInterface $accountBalanceOperationResultMapper
     */
    public function __construct(
        Client $guzzleClient,
        AccountMapperInterface $accountMapper,
        AccountBalanceOperationResultMapperInterface $accountBalanceOperationResultMapper
    ){
        $this->guzzleClient = $guzzleClient;
        $this->accountMapper = $accountMapper;
        $this->accountBalanceOperationResultMapper = $accountBalanceOperationResultMapper;
    }


    /**
     * @inheritDoc
     */
    public function fetchWithUserIdAndAccountId(
        string $userId,
        string $accountId
    ): AccountEntityInterface{
        $response = $this->guzzleClient->get(
            sprintf('/v1/wallets/users/%s/accounts/%s', $userId, $accountId)
        );

        return $this->accountMapper->createAccountFromApiResponse(
            $response
        );
    }

    /**
     * @inheritDoc
     */
    public function topUpWithUserIdAndAccountId(
        string $userId,
        string $accountId,
        string $amount,
        string $description
    ): AccountBalanceOperationResultInterface{
        $response = $this
            ->guzzleClient
            ->patch(
                sprintf(
                    '/v1/wallets/users/%s/accounts/%s/balance/topUp',
                    $userId,
                    $accountId
                ),
                [
                    RequestOptions::JSON => [
                        'amount'=>$amount,
                        'description'=>$description
                    ]
                ]
            );

        return $this->accountBalanceOperationResultMapper->fromApiResponse(
            $response
        );
    }


    /**
     * @inheritDoc
     */
    public function debitWithUserIdAndAccountId(
        string $userId,
        string $accountId,
        string $amount,
        string $description
    ): AccountBalanceOperationResultInterface {
        $response = $this
            ->guzzleClient
            ->patch(
                sprintf(
                    '/v1/wallets/users/%s/accounts/%s/balance/debit',
                    $userId,
                    $accountId
                ),
                [
                    RequestOptions::JSON => [
                        'amount'=>$amount,
                        'description'=>$description
                    ]
                ]
            );

        return $this->accountBalanceOperationResultMapper->fromApiResponse(
            $response
        );
    }
}
