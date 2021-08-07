<?php


namespace Infrastructure\Api\Rest\Client\WalletGateway\User\Mapper;


use Payment\Account\Entity\AccountEntity;
use Payment\Wallet\User\Entity\UserEntity;
use Payment\Wallet\User\Entity\UserEntityInterface;
use Psr\Http\Message\ResponseInterface;

class UserMapper implements UserMapperInterface
{

    /**
     * @inheritDoc
     */
    public function createUserFromApiResponse(
        ResponseInterface $response
    ): UserEntityInterface
    {
        $userData = json_decode(
            $response->getBody()->getContents(),
            true
        );

        return new UserEntity(
            $userData['data']['walletAccountUser']['lastName'] ?? null,
            $userData['data']['walletAccountUser']['firstName'] ?? null,
            $userData['data']['walletAccountUser']['address'] ?? null,
            $userData['data']['walletAccountUser']['email'] ?? null,
            $userData['data']['walletAccountUser']['phoneNumber'] ?? null,
            $userData['data']['walletAccountUser']['mobileNumber'] ?? null,
            $userData['data']['walletAccountUser']['language'] ?? null,
            $userData['data']['walletAccountUser']['walletOrganizations'],
            $userData['data']['walletAccountUser']['userId']
        );
    }
}
