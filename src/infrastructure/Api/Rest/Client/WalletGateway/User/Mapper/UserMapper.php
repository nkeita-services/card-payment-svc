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
            $userData['data']['walletAccountUser']['lastName'],
            $userData['data']['walletAccountUser']['firstName'],
            $userData['data']['walletAccountUser']['address'],
            $userData['data']['walletAccountUser']['email'],
            $userData['data']['walletAccountUser']['phoneNumber'],
            $userData['data']['walletAccountUser']['mobileNumber'],
            $userData['data']['walletAccountUser']['language'],
            $userData['data']['walletAccountUser']['walletOrganizations'],
            $userData['data']['walletAccountUser']['userId']
        );
    }
}
