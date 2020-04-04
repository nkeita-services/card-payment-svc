<?php


namespace Infrastructure\Api\Rest\Client\Account;


use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Infrastructure\Api\Rest\Client\Account\Mapper\AccountMapperInterface;
use Wallet\Account\Entity\AccountEntityInterface;
use Wallet\Wallet\Account\Collection\AccountCollectionInterface;

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
     * AccountApiGuzzleHttpClient constructor.
     * @param Client $guzzleClient
     * @param AccountMapperInterface $accountMapper
     */
    public function __construct(Client $guzzleClient, AccountMapperInterface $accountMapper)
    {
        $this->guzzleClient = $guzzleClient;
        $this->accountMapper = $accountMapper;
    }


    public function create(array $accountPayload): AccountEntityInterface
    {

        $response = $this->guzzleClient->post('/v1/accounts', [
            RequestOptions::JSON => $accountPayload
        ]);

        return $this->accountMapper->createAccountFromApiResponse(
            $response
        );
    }

    /**
     * @inheritDoc
     */
    public function fetchAll(array $filter): AccountCollectionInterface
    {
        $response = $this->guzzleClient->get('/v1/accounts', [
            RequestOptions::QUERY => $filter
        ]);

        return $this
            ->accountMapper
            ->createAccountCollectionFromApiResponse(
                $response
            );
    }

    /**
     * @inheritDoc
     */
    public function update(string $accountId, array $data): AccountEntityInterface
    {
        $response = $this->guzzleClient->patch(sprintf('/v1/accounts/%s', $accountId), [
            RequestOptions::JSON => $data
        ]);

        return $this->accountMapper->createAccountFromApiResponse(
            $response
        );
    }

    /**
     * @inheritDoc
     */
    public function fetch(string $accountId): AccountEntityInterface
    {
        $response = $this->guzzleClient->get(
            sprintf('/v1/accounts/%s', $accountId)
        );

        return $this->accountMapper->createAccountFromApiResponse(
            $response
        );
    }


}
