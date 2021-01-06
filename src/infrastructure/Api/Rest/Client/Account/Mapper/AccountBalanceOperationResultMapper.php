<?php


namespace Infrastructure\Api\Rest\Client\Account\Mapper;


use Payment\Account\Entity\AccountBalanceOperationResult;
use Payment\Account\Entity\AccountBalanceOperationResultInterface;
use Payment\Account\Entity\AccountEntity;
use Psr\Http\Message\ResponseInterface;

class AccountBalanceOperationResultMapper implements AccountBalanceOperationResultMapperInterface
{

    /**
     * @inheritDoc
     */
    public function fromApiResponse(ResponseInterface $response): AccountBalanceOperationResultInterface
    {
        $accountData = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return new AccountBalanceOperationResult(
            new AccountEntity(
                $accountData['data']['walletAccount']['accountType'],
                $accountData['data']['walletAccount']['balance'],
                $accountData['data']['walletAccount']['userId'],
                $accountData['data']['walletAccount']['walletPlanId'],
                $accountData['data']['walletAccount']['accountId'],
                $accountData['data']['walletAccount']['organizations']
            ),
            $accountData['data']['TransactionDetails']
        );

    }
}
