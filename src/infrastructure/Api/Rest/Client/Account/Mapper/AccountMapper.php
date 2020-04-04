<?php


namespace Infrastructure\Api\Rest\Client\Account\Mapper;


use Psr\Http\Message\ResponseInterface;
use Wallet\Account\Entity\AccountEntityInterface;
use Wallet\Account\Entity\AccountEntity;
use Wallet\Wallet\Account\Collection\AccountCollection;
use Wallet\Wallet\Account\Collection\AccountCollectionInterface;

class AccountMapper implements AccountMapperInterface
{

    /**
     * @inheritDoc
     */
    public function createAccountFromApiResponse(ResponseInterface $response): AccountEntityInterface
    {
        $accountData = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return new AccountEntity(
            $accountData['data']['walletAccount']['accountType'],
            $accountData['data']['walletAccount']['balance'],
            $accountData['data']['walletAccount']['userId'],
            $accountData['data']['walletAccount']['walletPlanId'],
            $accountData['data']['walletAccount']['accountId'],
            $accountData['data']['walletAccount']['organizations']
        );
    }

    /**
     * @inheritDoc
     */
    public function createAccountCollectionFromApiResponse(
        ResponseInterface $response
    ): AccountCollectionInterface
    {
        $data = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return AccountCollection::fromArray(
            $data['data']['walletAccounts']
        );
    }


}
